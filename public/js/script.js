// $(document).ready(function () {
//     fetchTodoList()
// })
    

// $('#todoForm').submit(function(event) {
    
//     event.preventDefault();
//     $('#todoerror').html("");

//     var data = {
//         'todo': $('#todo').val(),
//     }

//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });

//     $.ajax({
//         type: "POST",
//         url: "/todolist/store",
//         data: data,
//         dataType: "json",
//         success: function (data) {
//             // console.log(data)
//             $('#todo').val("")
//             $('#todosuccess').html(data.message).delay(2000).fadeOut();
//             fetchTodoList()
//             // if (response.status == 400) {
//             //     $('#save_msgList').html("");
//             //     $('#save_msgList').addClass('alert alert-danger');
//             //     $.each(response.errors, function (key, err_value) {
//             //         $('#save_msgList').append('<li>' + err_value + '</li>');
//             //     });
//             //     $('.add_student').text('Save');
//             // } else {
//             //     $('#save_msgList').html("");
//             //     $('#success_message').addClass('alert alert-success');
//             //     $('#success_message').text(response.message);
//             //     $('#AddStudentModal').find('input').val('');
//             //     $('.add_student').text('Save');
//             //     $('#AddStudentModal').modal('hide');
//             //     fetchstudent();
//             // }
//         },
//         error: function (xhr, textStatus){
//             if(xhr.status === 422){
//                 $('#todoerror').html(xhr.responseJSON.errors.todo[0]);
//             //    console.log(xhr.responseJSON.errors.todo[0])
//             }else{
//                 alert("Error")
//             }
//         }
//     });
// });

// function fetchTodoList() {
//     $.ajax({
//         type: "GET",
//         url: "/todolist/fetchlist",
//         dataType: "json",
//         success: function (response) {
//             console.log(response);
//             // $('tbody').html("");
//             // $.each(response.students, function (key, item) {
//             //     $('tbody').append('<tr>\
//             //         <td>' + item.id + '</td>\
//             //         <td>' + item.name + '</td>\
//             //         <td>' + item.course + '</td>\
//             //         <td>' + item.email + '</td>\
//             //         <td>' + item.phone + '</td>\
//             //         <td><button type="button" value="' + item.id + '" class="btn btn-primary editbtn btn-sm">Edit</button></td>\
//             //         <td><button type="button" value="' + item.id + '" class="btn btn-danger deletebtn btn-sm">Delete</button></td>\
//             //     \</tr>');
//             // });
//         }
//     });
// }


const editTodo = (todoId, todo) => {
    const element = document.getElementById("todo");
    element.value = todo;
    element.scrollIntoView();

    const alertdiv = document.getElementById("alertdiv");
    alertdiv.innerHTML = '';

    const errordiv =  document.getElementById("errordiv")
    errordiv.innerHTML = '';
    
    const btn = document.getElementById("submitbtn");
    btn.innerHTML = "Update Todo";

    const frm = document.getElementById('todoForm') || null;
    if(frm) {
        frm.action = '/todolist/update/'+todoId; 
    }
}


$('.toggle-badge').click(function() {
    var badge = $(this);
    var taskId = badge.closest('.task').data('id');
    var completed = badge.data('completed');


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '/task/' + taskId + '/toggle',
        type: 'POST',
        data: { completed: completed },
        success: function(response) {
            var task = response.task;
            var td = $('.task[data-id="' + task.id + '"]');
            td.find('.toggle-badge').removeClass('bg-success bg-warning text-dark');
            td.find('.toggle-badge').addClass(task.is_completed ? 'bg-success' : 'bg-warning text-dark');
            td.find('.toggle-badge').html(task.is_completed ? 'Completed' : 'Incomplete');
            td.find('.toggle-badge').data('completed', task.is_completed ? 1 : 0);
        },
        error: function(xhr) {
            // Handle error response
        }
    });
});

const deleteTodo = (todoId) => {
    alert()
}


const editIcons = document.querySelectorAll('.edit-task');


editIcons.forEach((icon) => {
  icon.addEventListener('click', (event) => {

    const firstTd = icon.closest('tr').querySelector('td:first-child');
  
    const text = firstTd.innerText;
   
    const inputName = icon.getAttribute('data-inputname');
    const formName = icon.getAttribute('data-formname');
    const taskid = icon.getAttribute('data-taskid');
    const todoid = icon.getAttribute('data-todoid');


    document.querySelector(`input[name="${inputName}"]`).value = text;

    const form = document.querySelector(`form[id="${formName}"]`);
    const submitButton = form.querySelector('button[type="submit"]');
    submitButton.textContent = 'Update Task';

    form.action = 'task/update/'+todoid+'/'+taskid;
  });
});


const alertBox = document.querySelector('.alert');
if (alertBox.classList.contains('show')) {
  setTimeout(() => {
    alertBox.parentNode.removeChild(alertBox);
  }, 3000);
}
