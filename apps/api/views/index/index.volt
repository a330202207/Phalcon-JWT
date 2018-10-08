<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登录</title>
    {{ partial('public/header') }}
</head>
<body>
<div id="showpage" style="display: none">
    <div class="form-group">
        <label for="username">用户名</label>
        <input type="text" class="form-control" id="username" placeholder="请输入用户名">
    </div>
    <div class="form-group">
        <label for="password">密码</label>
        <input type="password" class="form-control" id="password" placeholder="请输入密码">
    </div>
    <button type="submit" id="sub-btn" class="btn btn-default">登录</button>
</div>
<div id="user" style="display: none">
    <p>欢迎<strong id="uname"></strong>，您已登录，<a href="javascript:;" id="logout">退出>></a></p>
</div>
{{ partial('public/footer') }}
</body>
</html>
