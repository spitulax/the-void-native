function hideToast(id: string) {
    const toast = document.querySelector(`#${id}`) as HTMLDivElement;
    toast.classList.remove("opacity-100");
    toast.classList.add("opacity-0");
}

function showToast(id: string) {
    const toast = document.querySelector(`#${id}`) as HTMLDivElement;
    toast.classList.remove("opacity-0");
    toast.classList.add("opacity-100");

    setTimeout(hideToast, 3000, id);
}
