document.addEventListener("DOMContentLoaded", () => {
    const nav = document.querySelector("#bottom-nav") as HTMLDivElement;
    const notifAlert = nav.querySelector("#notif-alert") as HTMLSpanElement;
    const userId = nav.dataset.userId!;

    if (userId) {
        const formData = new FormData();
        formData.append("id", userId);
        // TODO: Report error
        fetch("/notif/data", { method: "POST", body: formData })
            .then((res) => res.json())
            .then((data) => {
                if (data.count > 0) {
                    notifAlert.classList.remove("hidden");
                } else {
                    notifAlert.classList.add("hidden");
                }
            });
    }
});
