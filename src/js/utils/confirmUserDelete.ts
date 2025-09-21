document.addEventListener("DOMContentLoaded", () => {
    document
        .querySelectorAll("[data-component='user-delete']")
        .forEach((value) => {
            const div = value as HTMLDivElement;
            let form = div.querySelector("form") as HTMLFormElement;
            form.onsubmit = () =>
                confirm(
                    `Apakah Anda yakin ingin menghapus @${div.dataset.username!}?`,
                );
        });
});
