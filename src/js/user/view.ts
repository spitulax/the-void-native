document.addEventListener("DOMContentLoaded", () => {
    const buttons = document.querySelectorAll<HTMLButtonElement>(".tab-button");
    const tabs = document.querySelectorAll<HTMLDivElement>(".tab-content");
    const activeClasses = ["text-accent", "border-accent"];
    const inactiveClasses = ["border-gray"];

    buttons.forEach((button) => {
        button.onclick = () => {
            const target = button.dataset.tab!;

            buttons.forEach((button) => {
                button.classList.remove(...activeClasses);
                button.classList.add(...inactiveClasses);
                tabs.forEach((tab) => {
                    tab.classList.add("hidden");
                });
            });

            button.classList.add(...activeClasses);
            button.classList.remove(...inactiveClasses);
            document.getElementById(target)?.classList.remove("hidden");
        };
    });
});
