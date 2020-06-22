<form action="{{url('user/logindo')}}" method="post">@csrf
    <table>
        <tr>
            <td>账号</td>
            <td><input type="text" name="user_name">
            </td>
        </tr>
        <tr>
            <td>密码</td>
            <td><input type="password" name="password">
                <font color="orange">{{session("msg")}}</font>
            </td>
        </tr>
        <tr>
            <td><input type="submit" value="登录"></td>
            <td><a href="{{url('user/reg')}}">注册</a></td>
        </tr>
    </table>
</form>