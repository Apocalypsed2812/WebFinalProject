function managerLocation()
{
	window.location.href = "choose_manager.php";
}

function employeePage()
{
	window.location.href = "giamdoc1.php";
}

function departmentPage()
{
	window.location.href = "giamdoc.php";
} 

function dayOffPage()
{
	window.location.href = "dayoff.php";
}

function resetLocation()
{
	window.location.href = "reset_password.php";
}


//reset account for employee
let idReset = document.getElementById('id_reset');
let nameReset = document.getElementById('name_reset');
let resetAccount = document.querySelectorAll('.reset_account');
resetAccount.forEach(item => {
	item.onclick = () => {
		let idReset1 = item.getAttribute('data-id');
		let nameReset1 = item.getAttribute('data-name');
		idReset.value = idReset1;
		nameReset.value = nameReset1;
		console.log(idReset.value);
		console.log(nameReset.value);
	}
})

//view information department
let idBox = document.getElementById('id2');
let nameBox = document.getElementById('name2');
let managerBox = document.getElementById('manager2');
let contactBox = document.getElementById('contact2');
let phoneBox = document.getElementById('phone2');
let describeBox = document.getElementById('describe2');
let views = document.querySelectorAll('.view');
views.forEach(item => {
	item.onclick = () => {
		let id2 = item.getAttribute('data-id');
		let name2 = item.getAttribute('data-name');
		let manager2 = item.getAttribute('data-manager');
		let contact2 = item.getAttribute('data-contact');
		let phone2 = item.getAttribute('data-phone');
		let describe2 = item.getAttribute('data-describe');
		idBox.value = id2;
		nameBox.value = name2;
		managerBox.value = manager2;
		contactBox.value = contact2;
		phoneBox.value = phone2;
		describeBox.value = describe2;
		console.log(idBox.value)
	}
})

//edit department
let a = document.getElementById('id_department');
let idEditBox = document.getElementById('id1');
let nameEditBox = document.getElementById('name1');
let managerEditBox = document.getElementById('manager1');
let contactEditBox = document.getElementById('contact1');
let phoneEditBox = document.getElementById('phone1');
let describeEditBox = document.getElementById('describe1');
let edits = document.querySelectorAll('.edit');
edits.forEach(item => {
	item.onclick = () => {
		let id1 = item.getAttribute('data-id');
		let name1 = item.getAttribute('data-name');
		let manager1 = item.getAttribute('data-manager');
		let contact1 = item.getAttribute('data-contact');
		let phone1 = item.getAttribute('data-phone');
		let describe1 = item.getAttribute('data-describe');
		a.value = id1;
		idEditBox.value = id1;
		nameEditBox.value = name1;
		managerEditBox.value = manager1;
		contactEditBox.value = contact1;
		phoneEditBox.value = phone1;
		describeEditBox.value = describe1;
		console.log(a.value);
	}
})



//view employee	
let idnvBox = document.getElementById('idnv');
let namenvBox = document.getElementById('namenv');
let tentkBox = document.getElementById('tentk');
let positionBox = document.getElementById('position');
let departmentBox = document.getElementById('department');
let viewe = document.querySelectorAll('.viewEmployee');
viewe.forEach(item => {
	item.onclick = () => {
		let idnv = item.getAttribute('data-id');
		let namenv = item.getAttribute('data-name');
		let tentk = item.getAttribute('data-tentk');
		let position = item.getAttribute('data-position');
		let department = item.getAttribute('data-department');
		idnvBox.value = idnv;
		namenvBox.value = namenv;
		tentkBox.value = tentk;
		positionBox.value = position;
		departmentBox.value = department;
	}
})

//choose manager
let idManager = document.getElementById('idChooseManager');
let nameManager = document.getElementById('chooseManager');
let temp = document.getElementById('temp');
let choose = document.querySelectorAll('.choose');
choose.forEach(item => {
	item.onclick = () => {
		let idChoose = item.getAttribute('data-id');
		let nameChoose = item.getAttribute('data-name');
		idManager.value = idChoose;
		nameManager.value = nameChoose;
		temp.innerHTML = nameChoose;
		console.log(idManager.value);
		console.log(nameManager.value);
	}
})

//get id for delete employee
let idDelete = document.getElementById('id_delete');
let deleteEmployee = document.querySelectorAll('.deleteEmployee');
let nameDeleteEmployee = document.getElementById('name_delete_employee');
deleteEmployee.forEach(item => {
	item.onclick = () => {
		let idDelete1 = item.getAttribute('data-id');
		let nameDelete1 = item.getAttribute('data-name');
		idDelete.value = idDelete1;
		nameDeleteEmployee.innerHTML = nameDelete1;
		console.log(idDelete.value);
	}
})

//get id for delete department
let idDeleteDepartment = document.getElementById('id_delete_department');
let nameDelete = document.getElementById('name_delete');
let deleteDepartment = document.querySelectorAll('.delete_department');
deleteDepartment.forEach(item => {
	item.onclick = () => {
		let idDeleteDepartment1 = item.getAttribute('data-id');
		let nameDeleteDepartment1 = item.getAttribute('data-name');
		idDeleteDepartment.value = idDeleteDepartment1;
		nameDelete.innerHTML = nameDeleteDepartment1;
		console.log(idDeleteDepartment.value);
		console.log(nameDelete.value);
	}
})

//edit employee
let idOldEmployee = document.getElementById('id_employee');
let idEditEmployee = document.getElementById('idnv2');
let nameEditEmployee = document.getElementById('namenv2');
let tentkEditEmployee = document.getElementById('tentk2');
let positionEditEmployee = document.getElementById('position2');
let departmentEditEmployee = document.getElementById('department2');
let editEmployee = document.querySelectorAll('.editEmployee');
editEmployee.forEach(item => {
	item.onclick = () => {
		let idEditEmployee1 = item.getAttribute('data-id');
		let nameEditEmployee1 = item.getAttribute('data-name');
		let tentkEditEmployee1 = item.getAttribute('data-tentk');
		let positionEditEmployee1 = item.getAttribute('data-position');
		let departmentEditEmployee1 = item.getAttribute('data-department');
		idOldEmployee.value = idEditEmployee1;
		idEditEmployee.value = idEditEmployee1;
		nameEditEmployee.value = nameEditEmployee1;
		tentkEditEmployee.value = tentkEditEmployee1;
		positionEditEmployee.value = positionEditEmployee1;
		departmentEditEmployee.value = departmentEditEmployee1;
		console.log(idOldEmployee.value);
	}
})

//display error message for dayoff if dayoff have status is waiting
function showFailedDialog(message){
	document.getElementById("error-message").innerHTML = '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Failed!</strong>' + ' ' + message;
	document.getElementById("error-message").style.display = 'block';
	$('#delete-failed-modal').modal({show: true});
	$('#error-message').fadeIn(3000)
		setTimeout(()=>{
			$('#error-message').fadeOut(2000)
		}, 5000)
}

// get name of image select for add avatar
$(".custom-file-input").on("change", function() {
	var fileName = $(this).val().split("\\").pop();
	$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

let numdayoff = document.getElementById('numdayoff');
let reason = document.getElementById('reason');
let attach = document.getElementById('attach');
let approved = document.getElementById('id_approved');
let refused = document.getElementById('id_refused');
let dayoff = document.querySelectorAll('.dayoff');
dayoff.forEach(item => {
	item.onclick = () => {
		let numdayoff1 = item.getAttribute('data-numberoff');
		let reason1 = item.getAttribute('data-reason');
		let attach1 = item.getAttribute('data-attach');
		let tentkdayoff = item.getAttribute('data-tentk');
		numdayoff.value = numdayoff1;
		reason.value = reason1;
		attach.value = attach1;
	}
})

let dayoffa = document.querySelectorAll('.dayoffa');
dayoffa.forEach(item => {
	item.onclick = () => {
		let dayoffapproved = item.getAttribute('data-tentk');
		approved.value = dayoffapproved;
	}
})

let dayoffr = document.querySelectorAll('.dayoffr');
dayoffr.forEach(item => {
	item.onclick = () => {
		let dayoffrefused = item.getAttribute('data-tentk');
		refused.value = dayoffrefused;
	}
})

function toast({
	title='', 
	message='', 
	type = 'success', 
	duration = 3000
}) {
	const main = document.getElementById('toast');
	if(main){
		const toast = document.createElement('div');
		const icons = {
			success: 'far fa-check-circle',
			error: 'fas fa-exclamation-circle',
		};
		const icon = icons[type];
		const delay = (duration/1000).toFixed(2);

		toast.classList.add('toast', `toast--${type}`);
		toast.style.animation = `slideInLeft ease 2s, fadeOut linear 2s 6s forwards`;

		toast.innerHTML = `
		<div class="toast__icon">
			<i class="${icon}"></i>
		</div>
		<div class="toast__body">
			<h3 class="toast__title">${title}</h3>
			<p class="toast__msg">${message}</p>
		</div>
		<div class="toast__close">
			<i class="fas fa-times"></i>
		</div>
		`;
		main.appendChild(toast);
		setTimeout(function(){
			main.removeChild(toast)
		}, duration + 1000)
	}
}

function showSuccessToast(input){
	toast({
		title: 'Success',
		message: input,
		type: 'success',
		duration: 1000
	})
}

function showErrorToast(input){
	toast({
		title: 'Error',
		message: input,
		type: 'error',
		duration: 1000
	})
}