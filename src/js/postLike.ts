document.addEventListener("DOMContentLoaded", () => {
    document
        .querySelectorAll<HTMLDivElement>("[data-component='post-like']")
        .forEach((div) => {
            let button = div.querySelector("button") as HTMLButtonElement;
            let number = div.querySelector("span") as HTMLSpanElement;
            let svg = button.querySelector("svg") as SVGElement;

            const offClasses = [
                "stroke-text",
                "fill-transparent",
                "hover:fill-red",
                "hover:stroke-red",
            ];
            const onClasses = [
                "stroke-red",
                "fill-red",
                "hover:fill-transparent",
                "hover:stroke-text",
            ];

            function refresh() {
                if (div.dataset.liked === "1") {
                    svg.classList.remove(...offClasses);
                    svg.classList.add(...onClasses);
                    number.classList.add("font-bold");
                } else {
                    svg.classList.remove(...onClasses);
                    svg.classList.add(...offClasses);
                    number.classList.remove("font-bold");
                }

                number.textContent = div.dataset.likes ?? "0";
            }

            refresh();

            button.onclick = () => {
                const formData = new FormData();
                formData.append("post_id", div.dataset.id!);

                fetch("/post/like", {
                    method: "POST",
                    body: formData,
                })
                    // TODO: Report error
                    .then((res) => res.json())
                    .then((data) => {
                        div.dataset.liked = data.liked ? "1" : "0";
                        div.dataset.likes = String(data.likes);
                        refresh();
                    });
            };
        });
});
