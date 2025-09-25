document.addEventListener("DOMContentLoaded", () => {
    document
        .querySelectorAll("[data-component='post-share']")
        .forEach((value) => {
            const button = value as HTMLButtonElement;
            const url = button.dataset.url!;
            button.onclick = () => {
                navigator.clipboard.writeText(url);
                // TODO: Own popup
                alert("Telah tersalin ke clipboard");
            };
        });
});
