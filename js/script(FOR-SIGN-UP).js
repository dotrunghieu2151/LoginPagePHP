function get(url,data) {
    return new Promise((resolve,reject)=>{
        const req = new XMLHttpRequest();
        req.open('POST',url);
        req.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        req.onload = () => req.status === 200 ? resolve(req.response) : reject(Error(req.statusText));
        req.onerror = (e) => reject(Error(`Network Error: ${e}`));
        req.send("getData="+data);
    });
}
const meterHidden = document.querySelector("input[type='hidden']");
const meter = document.querySelector('#pass-strength');
const meterMess = document.querySelector('#pass-message');
document.querySelector('#password').addEventListener('input',function(){
    const url = './validation/passwordStrength.php';
    get(url,this.value)
        .then( response => {return JSON.parse(response);})
        .then((response) => {
        meter.value = response.meterValue;
        meterMess.innerHTML = response.meterMess;
        meterHidden.value = response.meterValue;
    })
        .catch( err => console.log(err) );
});

