document.getElementById('login-form').addEventListener('submit', async function (event) {
    event.preventDefault();

    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;

    try { 
        let response = await fetch("../auth/process_login.php", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ email: email, password: password })
        });

        let result = await response.json();
        if (result.status === 'missing'){
            document.getElementById('response').textContent = result.message;
            document.getElementById('response').style.color = 'red';
        }
        else if (result.status === 'success') {
            window.location.href = result.redirect;
        } else  {
            document.getElementById('response').textContent = result.message;
            document.getElementById('response').style.color = 'red';
        }

    } catch(error) {
        console.error(error);
        document.getElementById('response').textContent = 'An error occurred. Please try again.';
        document.getElementById('response').style.color = 'red';
    }
});
