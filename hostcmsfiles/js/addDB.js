function addDB() {
    var myArray = localStorage;
    var xhr = new XMLHttpRequest();
    var url = 'myfile.php';
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
        console.log(xhr.responseText); // Обработка ответа от сервера
    }
    };
  
    var params = 'myArray=' + encodeURIComponent(JSON.stringify(myArray));
    xhr.send(params);
    
  }