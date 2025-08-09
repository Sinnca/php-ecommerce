document.getElementById('register-form').addEventListener('submit', async function (event) {
    event.preventDefault();

    let username = document.getElementById('username').value;
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;

    try { 
        let response = await fetch ("../auth/process_register.php", {
        method: "POST",
        headers: {
            'Content-type': 'application/json',
        },
        body: JSON.stringify({username: username, email: email, password: password})
    });
    let result = await response.text();
    document.getElementById('response').innerHTML = result;

    } catch(error){
        console.error(error);
    }
});