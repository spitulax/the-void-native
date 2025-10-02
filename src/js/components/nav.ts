document.addEventListener("DOMContentLoaded", () => {
    const nav = document.querySelector("#bottom-nav") as HTMLDivElement;
    const notifAlert = nav.querySelector("#notif-alert") as HTMLSpanElement;
    const userId = nav.dataset.userId!;

    if (userId) {
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

                    if (data.count > 0) {
                        notifAlert.classList.remove("hidden");
                    } else {
                        notifAlert.classList.add("hidden");
                    }
                }
            });
    }
});
