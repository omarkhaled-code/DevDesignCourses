

let cancileButton = document.querySelector('.no');
let logoutButton = document.querySelector('#logout');
let layout = document.querySelector('.layout');
let logoutBox = document.querySelector('.logout-box')
let updateButton = document.querySelector('#update')

let logoutState = false;


const handleActive = (box)=>{
    

    if (logoutState) {
        layout.style.display='block';
        box.style.display='block';
    }else {
        layout.style.display='none';
        box.style.display='none';
    }
}

if (logoutButton) {

    logoutButton.addEventListener('click', ()=> {
        logoutState = !logoutState;
        handleActive(logoutBox);
    })
}

if(cancileButton) {
    cancileButton.addEventListener('click', ()=> {
        logoutState = !logoutState;
        handleActive(logoutBox);
    })
}

// handle login and register animation
const container = document.getElementById('form-container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

const smallRegisterBtn = document.getElementById('small-register');
const smallLoginBtn = document.getElementById('small-login');




registerBtn.addEventListener('click', () => {
    container.classList.remove("active");
    
});

loginBtn.addEventListener('click', () => {
    container.classList.add("active");
});

smallRegisterBtn.addEventListener('click', () => {
    container.classList.remove("active");
    
});

smallLoginBtn.addEventListener('click', () => {
    container.classList.add("active");
});




