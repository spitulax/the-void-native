document.addEventListener("DOMContentLoaded", () => {
    const topNavTitle = document.querySelector(
        "#top-nav-title",
    ) as HTMLHeadingElement;
    const clearAll = document.querySelector("#clear-all") as HTMLButtonElement;
    const container = document.querySelector("#container") as HTMLDivElement;
    const userId = container.dataset.userId!;

    function refresh() {
        const formData = new FormData();
        formData.append("id", userId);
        fetch("/notif/data", { method: "POST", body: formData })
            // TODO: Report error
            .then((res) => res.json())
            .then((data) => {
                topNavTitle.textContent = `Notifikasi (${data.count})`;
            });
    }

    refresh();

    clearAll.onclick = () => {
        Array.from(container.children).forEach((child) => {
            child.classList.add("hidden");
        });

        const formData = new FormData();
        formData.append("id", userId);
        // TODO: Report error
        fetch("/notif/clear", { method: "POST", body: formData });
        refresh();
    };

    document.querySelectorAll<HTMLDivElement>("#notif").forEach((div) => {
        const deleteButton = div.querySelector("#delete") as HTMLButtonElement;
        deleteButton.onclick = () => {
            div.classList.add("hidden");
            const formData = new FormData();
            formData.append("id", div.dataset.id!);
            // TODO: Report error
            fetch("/notif/delete", { method: "POST", body: formData });
            refresh();
        };
    });
});
