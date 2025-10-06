document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("[data-component='share']").forEach((value) => {
        const button = value as HTMLButtonElement;
        const url = button.dataset.url!;
        button.onclick = () => {
            navigator.clipboard.writeText(url);
            showToast("share-toast");
        };
    });
});
