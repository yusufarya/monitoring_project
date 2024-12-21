$(function () {

    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        // Toggle password visibility
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    console.log("ready");
    const imgInp = document.getElementById("images");
    let blah = document.getElementById("blah");
    imgInp.onchange = (evt) => {
        const [file] = imgInp.files;

        if (file) {
            blah.src = URL.createObjectURL(file);
        }
    };
});

function changeUsername() {
    const username = document.getElementById("username").value;
    const usnm = username.replaceAll(" ", "_");
    // console.log(usnm);
    document.getElementById("username").value = usnm.toLowerCase();
}

var invalid = document.getElementById("invalid").value;
console.log(invalid);
var valid = document.getElementById("valid").value;
if (valid) {
} else if (invalid) {
}
