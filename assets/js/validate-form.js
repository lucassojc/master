function validateForm() {
    let status = true;

    document.querySelector('#error-message').classList.add('d-none');
    document.querySelector('#error-message').innerHTML = '';
    
    const godina2019 = document.querySelector('#godina_2019');
    const godina2020 = document.querySelector('#godina_2020');
    const godina2021 = document.querySelector('#godina_2021');
    const iznosBezPdv = document.querySelector('#iznos_bez_pdv');
    const godine = godina2019 + godina2020 + godina2021;

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