function confirmDelete(id: string) {
    hideConfirm(id);

    const form = document.createElement("form");
    form.method = "POST";
    form.action = "/post/delete";

    const input = document.createElement("input");
    input.type = "hidden";
    input.name = "id";
    input.value = id;
    form.appendChild(input);

    document.body.appendChild(form);
    form.submit();
}
