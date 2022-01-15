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

function requestPage(){
	window.location.href = "request.php";
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
let contactEditBox = document.getElementById('contact1');
let phoneEditBox = document.getElementById('phone1');
let describeEditBox = document.getElementById('describe1');
let edits = document.querySelectorAll('.edit');
edits.forEach(item => {
	item.onclick = () => {
		let id1 = item.getAttribute('data-id');
		let name1 = item.getAttribute('data-name');
		let contact1 = item.getAttribute('data-contact');
		let phone1 = item.getAttribute('data-phone');
		let describe1 = item.getAttribute('data-describe');
		a.value = id1;
		idEditBox.value = id1;
		nameEditBox.value = name1;
		contactEditBox.value = contact1;
		phoneEditBox.value = phone1;
		describeEditBox.value = describe1;
		console.log(a.value);
	}
})



//view employee		
let idnvBox = document.getElementById('idnv');
let namenvBox = document.getElementById('namenv');
let tentkBox = document.getElementById('username');
let positionBox = document.getElementById('position');
let departmentBox = document.getElementById('department');
let iddepartmentBox = document.getElementById('id_department');
let emailBox = document.getElementById('email');
let phoneEmployeeBox = document.getElementById('phone');
let indentityBox = document.getElementById('indentity');
let genderBox = document.getElementById('gender');
let viewe = document.querySelectorAll('.viewEmployee');
viewe.forEach(item => {
	item.onclick = () => {
		let idnv = item.getAttribute('data-id');
		let namenv = item.getAttribute('data-name');
		let tentk = item.getAttribute('data-tentk');
		let position = item.getAttribute('data-position');
		let department = item.getAttribute('data-department');
		let id_department = item.getAttribute('data-iddepartment');
		let email = item.getAttribute('data-email');
		let phone = item.getAttribute('data-phone');
		let indentity = item.getAttribute('data-indentity');
		let gender = item.getAttribute('data-gender');
		idnvBox.value = idnv;
		namenvBox.value = namenv;
		tentkBox.value = tentk;
		positionBox.value = position;
		departmentBox.value = department;
		iddepartmentBox.value = id_department;
		emailBox.value = email;
		phoneEmployeeBox.value = phone;
		indentityBox.value = indentity;
		genderBox.value = gender;
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
let idDepartmentEditEmployee = document.getElementById('id_department2');
let emailEditEmployee = document.getElementById('email2');
let phoneEditEmployee = document.getElementById('phone2');
let indentityEditEmployee = document.getElementById('indentity2');
let genderEditEmployee = document.getElementById('gender2');
let editEmployee = document.querySelectorAll('.editEmployee');
editEmployee.forEach(item => {
	item.onclick = () => {
		let idEditEmployee1 = item.getAttribute('data-id');
		let nameEditEmployee1 = item.getAttribute('data-name');
		let tentkEditEmployee1 = item.getAttribute('data-tentk');
		let positionEditEmployee1 = item.getAttribute('data-position');
		let departmentEditEmployee1 = item.getAttribute('data-department');
		let idDepartmentEditEmployee1 = item.getAttribute('data-iddepartment');
		let emailEditEmployee1 = item.getAttribute('data-email');
		let phoneEditEmployee1 = item.getAttribute('data-phone');
		let indentityEditEmployee1 = item.getAttribute('data-indentity');
		let genderEditEmployee1 = item.getAttribute('data-gender');
		idOldEmployee.value = idEditEmployee1;
		idEditEmployee.value = idEditEmployee1;
		nameEditEmployee.value = nameEditEmployee1;
		tentkEditEmployee.value = tentkEditEmployee1;
		positionEditEmployee.value = positionEditEmployee1;
		departmentEditEmployee.value = departmentEditEmployee1;
		idDepartmentEditEmployee.value = idDepartmentEditEmployee1;
		emailEditEmployee.value = emailEditEmployee1;
		phoneEditEmployee.value = phoneEditEmployee1;
		indentityEditEmployee.value = indentityEditEmployee1;
		genderEditEmployee.value = genderEditEmployee1;
		console.log(idOldEmployee.value);
	}
})

//view task manager
let idTask = document.getElementById('id-task');
let nameTask = document.getElementById('task-name');
let descTask = document.getElementById('description');
let statusTask = document.getElementById('status');
let assigneeTask = document.getElementById('assignee');
let deadlineTask = document.getElementById('due-to');
let viewTask = document.querySelectorAll('.viewTask');
viewTask.forEach(item => {
	item.onclick = () => {
		let idTask1 = item.getAttribute('data-id');
		let nameTask1 = item.getAttribute('data-name');
		let descTask1 = item.getAttribute('data-desc');
		let statusTask1 = item.getAttribute('data-status');
		let assigneeTask1 = item.getAttribute('data-assignee');
		let deadlineTask1 = item.getAttribute('data-deadline');
		idTask.value = idTask1;
		nameTask.value = nameTask1;
		descTask.value = descTask1;
		statusTask.value = statusTask1;
		assigneeTask.value = assigneeTask1;
		deadlineTask.value = deadlineTask1;
		if(statusTask1 == 'New')
		{
			document.getElementById("button-cancel").disabled = false;
		}
		else 
		{
			document.getElementById("button-cancel").disabled = true;
		}
	}
})

//view task reject
let idReject = document.getElementById('id');
let idnvReject = document.getElementById('idnv');
let reject_idsm = document.getElementById('reject_idsm');
let rejectTask = document.querySelectorAll('.reject');
rejectTask.forEach(item => {
	item.onclick = () => {
		let idReject1 = item.getAttribute('data-id');
		let idnvReject1 = item.getAttribute('data-idnv');
		let reject_idsm1 = item.getAttribute('data-idsm');
		idReject.value = idReject1;
		idnvReject.value = idnvReject1;
		reject_idsm.value = reject_idsm1;
	}
})

//view task employee
let idTaske = document.getElementById('id-task1');
let nameTaske = document.getElementById('task-name1');
let descTaske = document.getElementById('description1');
let statusTaske = document.getElementById('status1');
let assigneeTaske = document.getElementById('assignee1');
let deadlineTaske = document.getElementById('due-to1');
let evaluationTaske = document.getElementById('evaluation');
let labelevaluate = document.getElementById('labelevaluate');
//let filereject = document.getElementById('filereject');
//let filereject1 = document.getElementById('filereject1');
//let note = document.getElementById('note');
//let note1 = document.getElementById('note1');
let viewTaske = document.querySelectorAll('.viewTaskEmployee');
viewTaske.forEach(item => {
	item.onclick = () => {
		let idTaske1 = item.getAttribute('data-id');
		let nameTaske1 = item.getAttribute('data-name');
		let descTaske1 = item.getAttribute('data-desc');
		let statusTaske1 = item.getAttribute('data-status');
		let assigneeTaske1 = item.getAttribute('data-assignee');
		let deadlineTaske1 = item.getAttribute('data-deadline');
		let evaluationTaske1 = item.getAttribute('data-evaluation');
		idTaske.value = idTaske1;
		nameTaske.value = nameTaske1;
		descTaske.value = descTaske1;
		statusTaske.value = statusTaske1;
		assigneeTaske.value = assigneeTaske1;
		deadlineTaske.value = deadlineTaske1;
		evaluationTaske.value = evaluationTaske1;
		//evaluationTaske.style.visibility = 'hidden';
		//labelevaluate.style.visibility = 'hidden';
		evaluationTaske.style.display = 'none';
		labelevaluate.style.display = 'none';
		//filereject.style.display = 'none';
		//note.style.display = 'none';
		//filereject1.style.display = 'none';
		//note1.style.display = 'none';
		if(statusTaske1 == 'Rejected')
		{
			document.getElementById("button-reject").disabled = false;
			document.getElementById("button-start").style.display = 'none';
			document.getElementById("button-submit").innerHTML = 'Resubmit';
			//filereject.style.display = 'block';
			//note.style.display = 'block';
			//filereject1.style.display = 'block';
			//note1.style.display = 'block';
		}
		else if(statusTaske1 == 'Completed')
		{
			document.getElementById("button-start").style.display = 'none';
			//evaluationTaske.style.visibility = 'visible';
			//labelevaluate.style.visibility = 'visible';
			evaluationTaske.style.display = 'block';
			labelevaluate.style.display = 'block';
		}
		else if(statusTaske1 == 'New')
		{
			document.getElementById("button-start").style.display = 'block';
		}
		else{
			document.getElementById("button-reject").disabled = false;
			document.getElementById("button-start").style.display = 'none';
		}
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

//get id for submit task by employee
let submit_task = document.getElementById('submit_task');
let deadline_task = document.getElementById('deadline_task');
let idnvSubmit = document.getElementById('id_nv_task');
let submitEmployee = document.querySelectorAll('.submit');
submitEmployee.forEach(item => {
	item.onclick = () => {
		let idSubmit = item.getAttribute('data-id');
		let statusWaiting = item.getAttribute('data-status');
		let deadlineSubmit1 = item.getAttribute('data-deadline');
		let idnvSubmit1 = item.getAttribute('data-idnv');
		submit_task.value = idSubmit;
		deadline_task.value = deadlineSubmit1;
		idnvSubmit.value = idnvSubmit1;
		//console.log(deadline_task.value);
		if(statusWaiting == 'Waiting' || statusWaiting == 'New' || statusWaiting == 'Completed')
		{
			document.getElementById("button-submit").style.display = 'none';
		}
		else 
		{
			document.getElementById("button-submit").style.display = 'block';
		}
	}
})

//get id for status complete
/*let idtasksm = document.getElementById('idtask');
let idsm = document.getElementById('idsm');
let complete = document.querySelectorAll('.complete');
complete.forEach(item => {
	item.onclick = () => {
		let idtasksm1 = item.getAttribute('data-idtask');
		let idsm1 = item.getAttribute('data-idsm');
		idtasksm.value = idtasksm1;
		idsm.value = idsm1;
		//console.log(idtasksm.value);
		//console.log(idsm.value);
	}
})*/

//complete status with bad, good, ok and bad, good
function completeStatus(aTag){
	console.log(aTag)
	let td = aTag.parentElement
	let tr = td.parentElement
	let tds = tr.getElementsByTagName("td")

	let idsm = tds[1].innerHTML
	let idtask = tds[2].innerHTML
	let idnv = tds[4].innerHTML

	$('#idtask').val(idtask)
	$('#idsm').val(idsm)
	$('#idnv1').val(idnv)


	$.post("http://localhost:8080/truongphong/get_status_id.php", {
		id: idsm,
	}, function(data,status){
		console.log(data)
		let tableBody = ``
		data.data.forEach(element => {
			if(element.turnin == 'late')
			{
				tableBody = `
				<label for="evaluate">Evaluation</label>
				<select name="evaluate" required class="form-control" id="evaluate">
					<option value="Bad">Bad</option>
					<option value="OK">OK</option>
				</select>
				`
			}
			else{
				tableBody = `
					<label for="evaluate">Evaluation</label>
					<select name="evaluate" required class="form-control" id="evaluate">
						<option value="Bad">Bad</option>
						<option value="OK">OK</option>
						<option value="Good">Good</option>
					</select>
					`
			}	
		})
		$('#tbody-details').html(tableBody);
	},"json");
}
//view rejected task
function viewRequest(aTag){
	let td = aTag.parentElement
	let tr = td.parentElement
	let tds = tr.getElementsByTagName("td")

	let idtaskget = tds[0].innerHTML
	console.log(idtaskget);
	$.post("http://localhost:8080/nhanvien/get_reject.php", {
		id: idtaskget,
	}, function(data,status){
		console.log(data);
		let tableBody = ``
		data.data.forEach(element => {
			tableBody += `
			<tr>
				<td>`+element.idtask+`</td>
				<td>`+element.note+`</td>
				<td><a href="../minhchung/`+element.attach+`">`+element.attach+`</a></td>
			</tr>
			`
		})
		$('#tbody').html(tableBody);
	},"json");
}

//view task employee
function viewTaskOfEmployee(aTag){
	let td = aTag.parentElement
	let tr = td.parentElement
	let tds = tr.getElementsByTagName("td")

	let idtask = tds[0].innerHTML
	console.log(idtask)
	$.post("http://localhost:8080/nhanvien/get_task.php", {
		id: idtask,
	}, function(data,status){
		console.log(data)
		let tableBody = ``
		data.data.forEach(element => {
			if(element.status == 'Rejected'){
				document.getElementById("button-reject").disabled = false;
				document.getElementById("button-start").style.display = 'none';
				document.getElementById("button-submit").style.display = 'Block';
				//document.getElementById("button-submit").innerHTML = 'Resubmit';
				tableBody += `
				<div class="form-group">
					<label for="id">ID task</label>
					<p class="form-control">`+element.idtask+`</p>
				</div>
				<div class="form-group">
					<label for="task-name">Task name</label>
					<p class="form-control">`+element.name+`</p>
				</div>
				<div class="form-group">
					<label for="status">Status</label>
					<p class="form-control">`+element.status+`</p>
				</div>
				<div class="form-group">
					<label for="description">Description</label>
					<p class="form-control">`+element.description+`</p>
				</div>
				<div class="form-group">
					<label for="assignee">ID Employee</label>
					<p class="form-control">`+element.idnv+`</p>
				</div>
				<div class="form-group">
					<label for="due-to">Due to</label>
					<p class="form-control">`+element.dueto+`</p>
				</div>
				<div class="form-group">
					<label for="filereject">File Reject</label>
					<a name="filereject"  id="filereject" href="../minhchung/`+element.attach+`">`+element.attach+`</a>
				</div>
				<div class="form-group">
					<label id = "note1" for="note">Note</label>
					<p class="form-control">`+element.note+`</p>
				</div>
				`	
			}
			else if(element.status == 'Completed'){
				document.getElementById("button-start").style.display = 'none';
				document.getElementById("button-submit").style.display = 'none';
				tableBody += `
				<div class="form-group">
					<label for="id">ID task</label>
					<p class="form-control">`+element.idtask+`</p>
				</div>
				<div class="form-group">
					<label for="task-name">Task name</label>
					<p class="form-control">`+element.name+`</p>
				</div>
				<div class="form-group">
					<label for="status">Status</label>
					<p class="form-control">`+element.status+`</p>
				</div>
				<div class="form-group">
					<label for="description">Description</label>
					<p class="form-control">`+element.description+`</p>
				</div>
				<div class="form-group">
					<label for="assignee">ID Employee</label>
					<p class="form-control">`+element.idnv+`</p>
				</div>
				<div class="form-group">
					<label for="due-to">Due to</label>
					<p class="form-control">`+element.dueto+`</p>
				</div>
				<div class="form-group">
					<label id = "labelevaluate" for="evaluation">Evaluation</label>
					<p class="form-control">`+element.evaluate+`</p>
				</div>	`	
			}
			else if(element.status == 'In progress'){
				document.getElementById("button-start").style.display = 'none';
				tableBody += `
				<div class="form-group">
					<label for="id">ID task</label>
					<p class="form-control">`+element.idtask+`</p>
				</div>
				<div class="form-group">
					<label for="task-name">Task name</label>
					<p class="form-control">`+element.name+`</p>
				</div>
				<div class="form-group">
					<label for="status">Status</label>
					<p class="form-control">`+element.status+`</p>
				</div>
				<div class="form-group">
					<label for="description">Description</label>
					<p class="form-control">`+element.description+`</p>
				</div>
				<div class="form-group">
					<label for="assignee">ID Employee</label>
					<p class="form-control">`+element.idnv+`</p>
				</div>
				<div class="form-group">
					<label for="due-to">Due to</label>
					<p class="form-control">`+element.dueto+`</p>
				</div>
				`	
			}
			else if(element.status == 'Waiting'){
				document.getElementById("button-start").style.display = 'none';
				document.getElementById("button-submit").style.display = 'none';
				tableBody += `
				<div class="form-group">
					<label for="id">ID task</label>
					<p class="form-control">`+element.idtask+`</p>
				</div>
				<div class="form-group">
					<label for="task-name">Task name</label>
					<p class="form-control">`+element.name+`</p>
				</div>
				<div class="form-group">
					<label for="status">Status</label>
					<p class="form-control">`+element.status+`</p>
				</div>
				<div class="form-group">
					<label for="description">Description</label>
					<p class="form-control">`+element.description+`</p>
				</div>
				<div class="form-group">
					<label for="assignee">ID Employee</label>
					<p class="form-control">`+element.idnv+`</p>
				</div>
				<div class="form-group">
					<label for="due-to">Due to</label>
					<p class="form-control">`+element.dueto+`</p>
				</div>
				`	
			}
			else{
				document.getElementById("button-start").style.display = 'block';
				document.getElementById("button-submit").style.display = 'none';
				tableBody += `
				<div class="form-group">
					<label for="id">ID task</label>
					<input value="`+element.idtask+`" name="id" type="text" class="form-control" id="id">
				</div>
				<div class="form-group">
					<label for="task-name">Task name</label>
					<p class="form-control">`+element.name+`</p>
				</div>
				<div class="form-group">
					<label for="status">Status</label>
					<p class="form-control">`+element.status+`</p>
				</div>
				<div class="form-group">
					<label for="description">Description</label>
					<p class="form-control">`+element.description+`</p>
				</div>
				<div class="form-group">
					<label for="assignee">ID Employee</label>
					<p class="form-control">`+element.idnv+`</p>
				</div>
				<div class="form-group">
					<label for="due-to">Due to</label>
					<p class="form-control">`+element.dueto+`</p>
				</div>
				`	
			}
		})
		$('#tbody-view').html(tableBody);
	},"json");
}



//view task employee
function viewDayoff(aTag){
	let td = aTag.parentElement
	let tr = td.parentElement
	let tds = tr.getElementsByTagName("td")

	let idtask = tds[0].innerHTML
	console.log(idtask)
	$.post("http://localhost:8080/giamdoc/get_dayoff_by_id.php", {
		id: idtask,
	}, function(data,status){
		console.log(data)
		let tableBody = ``
		data.data.forEach(element => {
		
				tableBody += `
				<div class="form-group">
					<label for="numdayoff">Number dayoff</label>
					<p readonly class="form-control">` +element.numberoff+`</p>
				</div>
				<div class="form-group">
					<label for="reason">Reason</label>
					<p readonly class="form-control">` +element.reason+`</p>
				</div>
				<div class="form-group">
					<label>Attach File</label>
					<a href="../minhchung/`+element.attach+`">`+element.attach+`</a>
				</div>
				<div class="form-group">
					<label for="user">Username</label>
					<p readonly class="form-control">` +element.tentk+`</p>
				</div>
				<div class="form-group">
					<label for="day_request">Day Request</label>
					<p readonly class="form-control">` +element.day_request+`</p>
				</div>
				`
			
			
		})
		$('#body-dayoff').html(tableBody);
	},"json");
}

$(".custom-file-input").on("change", function() {
	var fileName = $(this).val().split("\\").pop();
	$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

$("#idnv-u").change(()=>{
	$.post("search_employee_by_id.php",{
		id: $("#idnv-u").val()
	}, function(data) {
		$("#assignee-u").val(data.data[0].name)
	})
})

function editTask() {
	if ($("#status").val()==="New" || $("#status").val()==="new"){
		$("#idnv-u").attr({readonly:false})
	} else {
		$("#idnv-u").attr({readonly:true})
	}

	$("#id-task-u").val($("#id-task").val())
	$("#task-name-u").val($("#task-name").val())
	$("#status-u").val($("#status").val())
	$("#description-u").val($("#description").val())
	$("#assignee-u").val($("#assignee").val())
	$("#due-to-u").val($("#due-to").val())
	
	$("#update-task").modal('show');
}

$("#update-button").click(()=>{
	$.post("update_task.php",{
		id_task: $("#id-task-u").val(),
		id_employee: $("#idnv-u").val(),
		description: $("#description-u").val(),
		deadline: $("#due-to-u").val()
	}, function(data) {
		showSuccessToast('Update task successfully');
		window.location.reload();
	})
})

//view submission
function viewMission(aTag){
	let td = aTag.parentElement
	let tr = td.parentElement
	let tds = tr.getElementsByTagName("td")

	let idsm = tds[1].innerHTML
	console.log(idsm);
	$.post("http://localhost:8080/truongphong/get_submission.php", {
		id: idsm,
	}, function(data,status){
		console.log(data);
		let tableBody = ``
		data.data.forEach(element => {
			tableBody += `
			<div class="form-group">
				<label for="id-task">ID task</label>
				<input readonly value="`+element.idtask+`" name="id-task" required class="form-control" type="text" placeholder="" id="id-task">
			</div>
			<div class="form-group">
				<label for="task-name">ID Employee</label>
				<input readonly value="`+element.idnv+`" name="task-name" required class="form-control" type="text" placeholder="" id="task-name">
			</div>
			<div class="form-group">
				<label>Attach File</label>
				<a class="form-control" href="../minhchung/`+element.attach+`">`+element.attach+`</a>
			</div>
			<div class="form-group">
				<label for="description">Description</label>
				<input readonly value="`+element.description+`" name="description" required class="form-control" type="text" placeholder="" id="description">
			</div>
			<div class="form-group">
				<label for="day_sm">Day Submit</label>
				<input readonly value="`+element.day_submit+`" name="day_sm" required class="form-control" type="text" placeholder="" id="day_sm">
			</div>
			<div class="form-group">
				<label for="turnin">Turn In</label>
				<input readonly value="`+element.turnin+`" name="turnin" required class="form-control" type="text" placeholder="" id="turnin">
			</div>
			`
		})
		$('#body-submission').html(tableBody);
	},"json");
}

$("#id3_gd").change(()=>{
	$.post("search_department_by_id.php",{
		id: $("#id3_gd").val()
	}, function(data) {
		$("#department_gd").val(data.data[0].name)
	})
})

$("#id_department1_dg1").change(()=>{
	$.post("search_department_by_id.php",{
		id: $("#id_department1_dg1").val()
	}, function(data) {
		$("#department1_gd1").val(data.data[0].name)
	})
})