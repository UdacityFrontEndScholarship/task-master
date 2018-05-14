<form class="col s12" action="add_task.php" method="post">
        <div class="row left-align add-task-title">
                <span class="left-space">Add New Task</span>
                <i class="material-icons left-space">alarm_add</i>
        </div>

        <div class="row">
          <div class="input-field col s12">
              <input type="text" name="title">
              <label for="task-title">Task Title</label>
          </div>

          <div class="input-field col s12">
              <textarea id="textarea1" name="description" class="materialize-textarea"></textarea>
              <label for="textarea1">Task Description</label>
          </div>

          <div class="input-field col s12 m6 l6 xl6">
              <select name="priority">
                <option value="high">HIGH</option>
                <option value="moderate" selected="selected">MODERATE</option>
                <option value="low">LOW</option>
              </select>
              <label>Task Priority</label>
          </div>

          <div class="input-field col s12 m6 l6 xl6">
              <select name="alarm_type">
                <option value="daily" selected="selected">Daily</option>
                <option value="weekly">Weekly</option>
                <option value="monthly">Monthly</option>
              </select>
              <label>Alarm Type</label>
          </div>

        </div> <!---row-->

    <div class="col s12">
            <div class="input-field col s12 m6 l6 xl6">
                    <input type="date" name="deadline">
                    <label for="">Deadline Date</label>
            </div>

            <div class="input-field col s12 m6 l6 xl6">
                    <input type="time" name="alarm_time">
                    <label for="">Alarm time</label>
            </div>

            <!--div class="input-field col s12 m6 l6 xl6">
                    <span><label for="attachments[]" >Attachments</label></span>
                    <input type="file" multiple name="attachments[]">
            </div-->





        <button class="btn waves-effect waves-light right" type="submit" name="action">Submit
            <i class="material-icons right">send</i>
        </button>

    </div>


</form>
