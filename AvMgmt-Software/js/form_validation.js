//Validate the login page form
function login_form(){  
	var uid = document.login.user_id; 
	var pwd = document.login.pword;
	if(userid_validation(uid)){  
		if(password_validation(pwd)){   
			return true;
		}  
		//return true;
	}  
	return false;  
}

//Validate the registration page form
function register_form(){  
	var first = document.registration.first_name; 
	var last = document.registration.last_name;
	var eml = document.registration.email; 
	var uid = document.registration.user_id; 
	var pwd = document.registration.pword; 
	var pword_val = document.registration.confirm_password; 
	if(first_validation(first)){  
		if(last_validation(last)){   
			if(email_validation(eml)){   
				if(userid_validation(uid)){   
					if(password_validation(pwd)){
						if(confirm_validation(pword, pword_val)){
							return true;
						}
					}
				}
			}
		} 
		//return true;
	}  
	return false;  
} 

//Validate first name
function first_validation(fname){  
var fname_len = fname.value.length;
var name = fname.value; 
var exp = /^(|[A-Z][a-zA-Z]{0,24})$/;
if (fname_len > 25 || fname_len < 0){  
alert("First Name length should be between 1 to 25");  
fname.focus();  
return false;  
}  
if(name.match(exp) == null){
	alert("Incorrect Format: Please start your first name with a capital letter. EX: Matthew");
	fname.focus();
	return false;
}
return true;  
}  

//Validate Last name
function last_validation(lname){  
var lname_len = lname.value.length; 
var name = lname.value;
var exp = /^(|[A-Z][a-zA-Z ]{0,24})$/;
if (lname_len > 25 || lname_len < 0){  
alert("Last Name length be between 1 to 25");  
lname.focus();  
return false;  
}  
if(name.match(exp) == null){
	alert("Incorrect Format: Please start your last name with a capital letter. Two Word Last Names are allowed. Ex: Mac Beth");
	lname.focus();
	return false;
}
return true;  
} 

//Validate email
function email_validation(Email){ 
var email_len = Email.value.length; 
var exp = /^[a-z][a-z0-9.]+@[a-z]+\.[a-z]+$/i;
var myemail = Email.value;
if(email_len == 0){
	alert("Email field is required");
	Email.focus();
	return false;
}
if(myemail.match(exp) == null){  
	alert("Check to make sure the email address has the format of person@domain.ext person starts with alphabetic character and may contain digits and dots. Domain and ext should be alphabetic.");
	Email.focus();
	return false;
}  
return true;
} 

//validate that password and confirm password blocks are the same
function confirm_validation(pword, pword_val){
	var pword = pword.value;
	var pword_val = pword_val.value;
	if(pword != pword_val){
		alert("Password field and Confirm Password fields must be the same.");
		pword.focus();
		return false;
	}
	return true;
}

//validate user id
function userid_validation(userid){  
	var userid_len = userid.value.length;
	var uid = userid.value; 
	var exp = /^[a-zA-Z0-9]{4,8}$/;
	if (userid_len == 0 || userid_len > 8 || userid_len < 4){  
		alert("User ID block should not be empty / length should be between 4 to 8");  
		userid.focus();  
		return false;  
	}  
	if(uid.match(exp) == null){
		alert("Incorrect Format: Userid must consist of between 4 to 8 alphanumeric characters. Example: MyName2 or myname2 both work");
		userid.focus();
		return false;
	}
	return true;  
} 

//validate password
function password_validation(pword){  
	var pword_len = pword.value.length;
	var pwd = pword.value; 
	var exp = /^[A-Za-z0-9]{4,8}$/
	if (pword_len == 0 || pword_len > 8 || pword_len < 4){  
		alert("Password block should not be empty / length should be between 4 to 8");  
		pword.focus();  
		return false;  
	}  
	if(pwd.match(exp) == null){
		alert("Incorrect Format: Password should be 4 to 8 alphanumeric characters. Example: MyDog3 and mydog3 both work");
		pword.focus();
		return false;
	}
	return true;  
} 
 