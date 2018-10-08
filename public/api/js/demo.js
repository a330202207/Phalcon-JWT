let jwt = localStorage.getItem('token');
console.log(jwt);
if (jwt) {
    axios.defaults.headers.common['token'] = jwt;
    axios.get('/api/index/login')
        .then(function (response) {
            if (response.data.status === 0) {
                document.querySelector('#showpage').style.display = 'none';
                document.querySelector('#user').style.display = 'block';
                document.querySelector('#uname').innerHTML = response.data.data.user_name;
            } else {
                document.querySelector('#showpage').style.display = 'block';
                console.log(response.data.msg);
            }
        })
        .catch(function (error) {
            console.log(error);
        });
} else {
    document.querySelector('#showpage').style.display = 'block';
}

document.querySelector('#sub-btn').onclick = function () {
    let username = document.querySelector('#username').value;
    let password = document.querySelector('#password').value;

    let key = 'x8fe3odTo4o7ff8CzjK9e3Dae59T4d4eKfKJFFEFt7OPj844cejFE4zCaCf9fFFo';
    let iss = 'ApiIss';
    let aud = 'ApiAud';
    let jti = 'Api';

    var params = new URLSearchParams();
    params.append('user_name', username);
    params.append('pass_word', password);
    params.append('key', key);
    params.append('iss', iss);
    params.append('aud', aud);
    params.append('jti', jti);

    axios.post(
        '/api/index/getToken',
        params
    ).then((response) => {
        if (response.data.status === 0) {
            // 本地存储token
            localStorage.setItem('token', response.data.data.token);
            // 把token加入header里
            axios.defaults.headers.common['token'] = response.data.data.token;

            axios.get('/api/index/login').then(function (response) {
                if (response.data.status === 0) {
                    document.querySelector('#showpage').style.display = 'none';
                    document.querySelector('#user').style.display = 'block';
                    document.querySelector('#uname').innerHTML = response.data.data.user_name;
                }
            });
        } else {
            console.log(response.data.msg);
        }
    }).catch(function (error) {
        console.log(error);
    });
}
