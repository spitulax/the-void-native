document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("#post-root").forEach((value) => {
        const root = value as HTMLDivElement;
        root.querySelectorAll("#approval-buttons").forEach((value) => {
            const div = value as HTMLDivElement;
            const reject = div.querySelector("#reject") as HTMLButtonElement;
            const approve = div.querySelector("#approve") as HTMLButtonElement;

            let formData = new FormData();
            formData.append("id", div.dataset.id!);

            approve.onclick = () => {
                // FIXME: Catch error response
                fetch("/admin/approve", {
                    method: "POST",
                    body: formData,
                }).then(() => {
                    showToast("approve-toast");
                    root.classList.add("hidden");
                });

                formData = new FormData();
                formData.append("id", div.dataset.authorId!);
                // FIXME: Add link to the post
                formData.append(
                    "text",
                    "Postingan anda telah disetujui admin.",
                );
                fetch("/notif/notify", { method: "POST", body: formData });
            };

            reject.onclick = () => {
                // FIXME: Catch error response
                fetch("/admin/reject", {
                    method: "POST",
                    body: formData,
                }).then(() => {
                    showToast("reject-toast");
                    root.classList.add("hidden");
                });
            };
        });
    });
});
