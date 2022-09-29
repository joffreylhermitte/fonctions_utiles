let d = new Date();
d.setTime(d.getTime() + (24*60*60*1000));
let expires = "expires="+ d.toUTCString();
document.cookie = "nomCookie=valeurCookie;" + expires + ";path=/";