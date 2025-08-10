document.getElementById('register-form').addEventListener('submit', async function (event) {
    event.preventDefault();

    let username = document.getElementById('username').value;
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;
    let confirm_password = document.getElementById('confirm_password').value;
    // check is username is not plain whitespace
    if (!username.trim()){
        document.getElementById('response').textContent = "Username is required";
        document.getElementById('response').style.color = "red";
        return;
    }
    // validate email format
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(email)) {
        document.getElementById('response').textContent = "Invalid Email Format";
        document.getElementById('response').style.color = "red";
        return; 
    }
    // check if password is 8 characters above
    if (password.length < 8){
        document.getElementById('response').textContent = "Password must contains 8 characters";
        document.getElementById('response').style.color = "red";
        return; 
    }
    // check if password and confirm password does match
    if (confirm_password !== password){
        document.getElementById('c-password').textContent = "Password does not match, make sure password is correct";
        document.getElementById('c-password').style.color = "red";
        return;
    }
    try { 
        let response = await fetch ("../auth/process_register.php", {
        method: "POST",
        headers: {
            'Content-type': 'application/json',
        },
        body: JSON.stringify({username: username, email: email, password: password, confirm_password: confirm_password})
    });
    let result = await response.json();
    if (result.status === "invalid_email"){
        document.getElementById('response').textContent = result.message;
        document.getElementById('response').style.color = "red";
    }
    else if (result.status === "invalid_password"){
        document.getElementById('response').textContent = result.message;
        document.getElementById('response').style.color = "red";
    }
    else if (result.status === "password_mismatch"){
        document.getElementById('response').textContent = result.message;
        document.getElementById('response').style.color = "red";
    }
    else if (result.status === "email_taken"){
        document.getElementById('response').textContent = result.message;
        document.getElementById('response').style.color = "red";
    }
    else if (result.status === "success"){
        document.getElementById('response').textContent = result.message;
        document.getElementById('response').style.color = "green";
    }
    else {
        document.getElementById('response').textContent = result.message;
        document.getElementById('response').style.color = "red";
    }

    } catch(error){
        console.error(error);
        document.getElementById('response').textContent = "An error occurred, Please Try Again";
        document.getElementById('response').style.color = "red";
    }
});