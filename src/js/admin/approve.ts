document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll<HTMLDivElement>("#post-root").forEach((root) => {
        root.querySelectorAll<HTMLDivElement>("#approval-buttons").forEach(
            (div) => {
                const reject = div.querySelector(
                    "#reject",
                ) as HTMLButtonElement;
                const approve = div.querySelector(
                    "#approve",
                ) as HTMLButtonElement;

                let formData = new FormData();
                formData.append("id", div.dataset.id!);

                approve.onclick = () => {
                    // TODO: Report error
                    fetch("/admin/approve", {
                        method: "POST",
                        body: formData,
                    }).then(() => {
                        showToast("approve-toast");
                        root.classList.add("hidden");
                    });

                    formData = new FormData();
                    formData.append("id", div.dataset.authorId!);
                    formData.append(
                        "heading",
                        "Postingan anda telah disetujui admin.",
                    );
                    formData.append("link_text", "Pergi ke postingan");
                    formData.append(
                        "link_address",
                        `/post/view.php?post=${div.dataset.id!}`,
                    );
                    // TODO: Report error
                    fetch("/notif/notify", { method: "POST", body: formData });
                };

                reject.onclick = () => {
                    // TODO: Report error
                    fetch("/admin/reject", {
                        method: "POST",
                        body: formData,
                    }).then(() => {
                        showToast("reject-toast");
                        root.classList.add("hidden");
                    });
                };
            },
        );
    });
});
