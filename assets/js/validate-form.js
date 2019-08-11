function validateForm() {
    let status = true;

    document.querySelector('#error-message').classList.add('d-none');
    document.querySelector('#error-message').innerHTML = '';
    
    const title = document.querySelector('#title').value;
    if (!title.match(/.*[^\s]{3,}.*/)) {
        document.querySelector('#error-message').innerHTML += 'Title must contain at least three visible characters. <br>';
        document.querySelector('#error-message').classList.remove('d-none');
        status =  false;
    }

    const description = document.querySelector('#description').value;
    if (!description.match(/.*[^\s]{5,}.*/)) {
        document.querySelector('#error-message').innerHTML += 'Description must contain at least five visible characters. <br>';
        document.querySelector('#error-message').classList.remove('d-none');
        status = false;
    }

    return status;
}