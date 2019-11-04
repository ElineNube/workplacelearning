<script>
document.getElementById('teacher_id').style.display = "none";
document.getElementById('wplp').style.display = "none";
document.getElementById('step-3').style.display = "none";
document.getElementById('error').style.display = "none";
document.getElementById('selectWPLP').onchange = chooseWPLP;

function showModel() {
  document.getElementById("myDropdown").classList.toggle("show");
}

function filterFunction() {
  var input, filter, ul, li, a, i;
  input = document.getElementById("dropdownInput");
  filter = input.value.toUpperCase();
  div = document.getElementById("myDropdown");
  a = div.getElementsByTagName("a");
  for (i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}

function chooseDocent(id) {
        document.getElementById('teacher_id').value = id;

         for(let teacher of teachers){
          if(teacher.student_id == id){
                document.getElementById('chosenTeacher').innerHTML = teacher.firstname + " " + teacher.lastname + '<br>' + teacher.email;
            } 
         }

         div = document.getElementById("myDropdown");
      a = div.getElementsByTagName("a");
      for (i = 0; i < a.length; i++) {
        a[i].style.display = "none";
  }
}

function chooseWPLP() {
        dropdown = document.getElementById('selectWPLP')
        document.getElementById('wplp').value = dropdown.options[dropdown.selectedIndex].value;
}

function chooseStudent(id) {
        document.getElementById("myDropdown").classList.toggle("show");
        var select =  document.getElementById("selectWPLP");
        var chosenStudent = '';
        removeOptions(selectWPLP)
        document.getElementById('error').style.display = "none";
        document.getElementById('step-3').style.display = "none";

        for(let student of students){
            if(student.student_id == id){
                chosenStudent = student.studentnr + ' - ' + student.firstname + " " + student.lastname;
            } 
        }

        var el = document.createElement("option");
                el.textContent = 'Kies een stage';
                select.appendChild(el);

        

       //Get all WPLP of the student
        for(let wplp of workplacelearningperiods){
            if(wplp.student_id == id) {
              document.getElementById('step-3').style.display = "";
              document.getElementById('error').style.display = "none";
              for(let workplace of workplaces) {
                if(workplace.wp_id == wplp.wp_id) {
                  var el = document.createElement("option");
                  el.textContent = workplace.wp_name;
                  el.value = wplp.wplp_id;
                  select.appendChild(el);
                }
              }
            } 
        }

        //Error if student has no WPLP
        if (select.options.length === 1) {
          document.getElementById('error').style.display = "";
          document.getElementById('step-3').style.display = "none";
        }

        

      //Clear 
      div = document.getElementById("myDropdown");
      a = div.getElementsByTagName("a");
      for (i = 0; i < a.length; i++) {
        a[i].style.display = "none";
         document.getElementById('dropdownInput').value =  chosenStudent;
      }
        
    }

    function removeOptions(selectbox)
    {
        var i;
        for(i = selectbox.options.length - 1 ; i >= 0 ; i--)
        {
            selectbox.remove(i);
        }
        
    }




</script>