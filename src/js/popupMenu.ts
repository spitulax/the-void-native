document.addEventListener("DOMContentLoaded", () => {
    const button = document.getElementById("menu-button") as HTMLButtonElement;
    const menu = document.getElementById("menu") as HTMLDivElement;

    button.onclick = () => {
        menu.classList.toggle("hidden");
    };

    document.onclick = (e) => {
        const target = e.target as HTMLElement;
        if (!button.contains(target) && !menu.contains(target)) {
            menu.classList.add("hidden");
        }
    };
});
