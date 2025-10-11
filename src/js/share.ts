document.addEventListener("DOMContentLoaded", () => {
    document
        .querySelectorAll<HTMLButtonElement>("[data-component='share']")
        .forEach((button) => {
            const url = button.dataset.url!;
            button.onclick = () => {
                navigator.clipboard.writeText(url);
                showToast("share-toast");
            };
        });
});
