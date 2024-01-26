{include file="header.tpl"}
<body id="task-form-page">
<div id="root">
    {include file="navigation.tpl"}
    <main>
        {if isset($message) && $message neq ''}

        {if $error}
            <div id="error-block">{$error}</div>
        {/if}

        {if $add}
            <div id="message-block">{$add}</div>
        {/if}

        {if $edit}
            <div id="message-block">{$edit}</div>
        {/if}
        {/if}
        <div class="content-card">
            <div class="content-card-header">Add Task</div>
            <div class="content-card-content">
                <form id="input-form" method="post" action="../save-task.php" enctype="multipart/form-data">

                    <input type="hidden" value="{$task.id|default:''}" name="id">
                    <div class="label-cell"><label for="desc">Description:</label></div>
                    <div class="input-cell">
                        <textarea id="desc" name="description">{$formData.description|default:$task.description|default:''|escape}</textarea>
                    </div>

                    <div class="label-cell">Estimate:</div>
                    <div class="input-cell">
                        {foreach from=$estimates item=estimate}
                            {assign var="checked" value=""}
                            {if isset($task) && $task.estimate == $estimate}
                                {assign var="checked" value="checked='checked'"}
                            {elseif $estimate == 1}
                                {assign var="checked" value="checked='checked'"}
                            {/if}
                            <label><input type='radio' name='estimate' value='{$estimate}' {$checked}/>{$estimate}</label>
                        {/foreach}
                    </div>


                    <div class="label-cell">Assigned to:</div>
                    <div class="input-cell">
                        <select id="employee" name="employeeId">
                            <option value=""></option>
                            {foreach from=$employees item=employee}
                                {assign var="selected" value=""}
                                {if $task.employeeId == $employee.id}
                                    {assign var="selected" value="selected"}
                                {/if}
                                <option value="{$employee.id}" {$selected}>{$employee.firstName|escape} {$employee.lastName|escape}</option>
                            {/foreach}
                        </select>
                    </div>

                    {if $isEditAction}
                        <div class="label-cell"><label for="isCompleted">Completed:</label></div>
                        <div class="input-cell">
                            <input id="isCompleted" type="checkbox" name="isCompleted" {if $formData.isCompleted || $task.isCompleted}checked{/if}/>
                        </div>
                    {/if}

                    <div class="input-cell button-cell">
                        <br>
                        {if $isEditAction}
                            <input name="deleteButton" class="button danger" type="submit" value="Delete">
                        {/if}
                        <br>
                        <br>
                        <button type="submit" class="main" name="submitButton">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    {include file="footer.tpl"}
</div>
</body>