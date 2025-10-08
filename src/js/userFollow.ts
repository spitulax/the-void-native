document.addEventListener("DOMContentLoaded", () => {
    document
        .querySelectorAll("[data-component='user-follow']")
        .forEach((value) => {
            const div = value as HTMLDivElement;

            let button = div.querySelector("button") as HTMLButtonElement;
            let number = div.querySelector("span") as
                | HTMLSpanElement
                | undefined;

            function refresh() {
                if (div.dataset.followed === "1") {
                    button.classList.add("my-button-on");
                    button.classList.remove("my-button");
                } else {
                    button.classList.add("my-button");
                    button.classList.remove("my-button-on");
                }

                if (number) {
                    number.textContent = div.dataset.follows ?? "0";
                }
            }

            refresh();

            button.onclick = () => {
                const formData = new FormData();
                formData.append("followed_id", div.dataset.id!);

                // TODO: Report error
                fetch("/user/follow", {
                    method: "POST",
                    body: formData,
                })
                    .then((res) => res.json())
                    .then((data) => {
                        div.dataset.followed = data.followed ? "1" : "0";
                        div.dataset.follows = String(data.follows);

                        refresh();
                    });
            };
        });
});
