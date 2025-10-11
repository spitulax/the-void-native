document.addEventListener("DOMContentLoaded", () => {
    const nav = document.querySelector("#bottom-nav") as HTMLDivElement;
    const userId = nav.dataset.userId!;
    const userAdmin = nav.dataset.userAdmin!;

    if (userId) {
        const notifAlert = nav.querySelector("#notif-alert") as HTMLSpanElement;

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

    if (userAdmin === "1") {
        const approveAlert = nav.querySelector(
            "#approve-alert",
        ) as HTMLSpanElement;

        fetch("/admin/approve-data", { method: "POST" })
            .then((res) => res.json())
            .then((data) => {
                if (data.pending > 0) {
                    approveAlert.classList.remove("hidden");
                } else {
                    approveAlert.classList.add("hidden");
                }
            });
    }
});
