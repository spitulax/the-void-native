function showConfirm(id: string) {
    const div = document.querySelector(
        `[data-component='confirm-dialog-${id}']`,
    ) as HTMLDivElement;
    div.classList.remove("opacity-0", "pointer-events-none");
    div.classList.add("opacity-100");
}

function hideConfirm(id: string) {
    const div = document.querySelector(
        `[data-component='confirm-dialog-${id}']`,
    ) as HTMLDivElement;
    div.classList.add("opacity-0", "pointer-events-none");
    div.classList.remove("opacity-100");
}
