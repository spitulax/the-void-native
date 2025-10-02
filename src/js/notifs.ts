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
            .then((res) => res.json())
            .then((data) => {
                if (data) {
                    if (data.redirect) {
                        // TODO: `flash` data is not sent
                        window.location.href = data.redirect;
                        return;
                    }

                    topNavTitle.textContent = `Notifikasi (${data.count})`;
                }
            });
    }

    refresh();

    clearAll.onclick = () => {
        Array.from(container.children).forEach((child) => {
            child.classList.add("hidden");
        });

        const formData = new FormData();
        formData.append("id", userId);
        fetch("/notif/clear", { method: "POST", body: formData });
        refresh();
    };

    document.querySelectorAll("#notif").forEach((value) => {
        const div = value as HTMLDivElement;

        const deleteButton = value.querySelector(
            "#delete",
        ) as HTMLButtonElement;
        deleteButton.onclick = () => {
            div.classList.add("hidden");
            const formData = new FormData();
            formData.append("id", div.dataset.id!);
            fetch("/notif/delete", { method: "POST", body: formData });
            refresh();
        };
    });
});
