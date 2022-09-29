let params = new FormData();
params.append('action','nomAction');

axios.post(window.location.origin + "/wp-admin/admin-ajax.php",params)
    .then(res => {

    })
    .catch(err => console.log(err))