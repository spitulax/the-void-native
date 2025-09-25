function showToast() {
    const toast = document.querySelector(
        "[data-component='post-share-toast']",
    ) as HTMLDivElement;
    toast.classList.remove("opacity-0");
    toast.classList.add("opacity-100");

    setTimeout(hideToast, 3000);
}

function hideToast() {
    const toast = document.querySelector(
        "[data-component='post-share-toast']",
    ) as HTMLDivElement;
    toast.classList.remove("opacity-100");
    toast.classList.add("opacity-0");
}

document.addEventListener("DOMContentLoaded", () => {
    document
        .querySelectorAll("[data-component='post-share']")
        .forEach((value) => {
            const button = value as HTMLButtonElement;
            const url = button.dataset.url!;
            button.onclick = () => {
                navigator.clipboard.writeText(url);
                showToast();
            };
        });
});
