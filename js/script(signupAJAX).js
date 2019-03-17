function get(url,data) {
    return new Promise((resolve,reject)=>{
        const request = new XMLHttpRequest();
        request.open('POST',url);
        request.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        request.onload =()=> request.status == 200 ? resolve(request.response) : reject(Error(request.statusText));
        request.onerror = (e) => reject(Error(`Network Error: ${e}`));
        request.send("getData="+data);
    });
}
document.querySelector('#theForm').addEventListener('submit',function(e){
    let user = {
       username: document.querySelector('#username').value,
       password: document.querySelector('#password').value,
       email: document.querySelector('#email').value
    };
   
    let userJSON = JSON.stringify(user);
    
    const url = './validation/signupAJAX.php';
    get(url,userJSON)
      .then((response)=>{
        let responseParsed = JSON.parse(response);
        if ( responseParsed.status === 'error') {
            let errorMessage = document.querySelectorAll('.error-mes');
            console.log()
            errorMessage[0].innerHTML = responseParsed.invalidU;
            errorMessage[1].innerHTML = responseParsed.invalidP;
            errorMessage[2].innerHTML = responseParsed.invalidE;
        } else if(responseParsed.status === 'ok') {
            window.location = 'http://localhost:82/loginpagePHP/';
        }
    })
      .catch((err)=>{console.log(err);});
    e.preventDefault();
});
