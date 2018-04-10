$(function(){
	$(".button").on("click",function(){
		var name = $(".name").val();
		var email = $(".email").val();
		if(name==""){
			alert("用户名不能为空");
			return false;
		}
		if(email==""){
			alert("密码不能为空");
			return false;
		}
	})
});