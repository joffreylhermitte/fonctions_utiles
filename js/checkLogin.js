function checkLogin(){
    let login = this.getCookie('nomCookie');
    if(login !== ""){
        return document.cookie
            .split('; ')
            .find(row => row.startsWith('nomCookie='))
            .split('=')[1];
    } else {
        return false;
    }

}