document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("#notify-form") as HTMLFormElement;

    form.onsubmit = (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        // TODO: Report error
        fetch("/notif/notify", { method: "POST", body: formData });
        form.reset();
    };
});
