function addCategory(form) {
    request('application/action/addCategory.php', {
            ['category']: form.category.value
        }, (response) => {
            location.reload();
        }, (response) => {
            alert(response);
        }
    );
}