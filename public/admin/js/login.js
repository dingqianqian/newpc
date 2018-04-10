$(function(){
	$(".button").on("click",function(){
		var name = $(".name").val();
		var password = $(".password").val();
		var code = $(".code").val();
		if(name==""){
			alert("用户名不能为空");
		}
		if(password==""){
			alert("密码不能为空");
		}
		if(code==""){
			alert("验证码不能为空");
		}
	})
});