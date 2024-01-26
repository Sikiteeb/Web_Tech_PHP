{include file="header.tpl"}
<body id="employee-form-page">
<div id="root">
    {include file="navigation.tpl"}
    <main>
        {if isset($error) && $error}
            <div id="error-block">{$error}</div>
        {/if}

        {if isset($add) && $add}
            <div id="message-block">{$add}</div>
        {/if}

        {if isset($edit) && $edit}
            <div id="message-block">{$edit}</div>
        {/if}

        <div class="content-card">
            <div class="content-card-header">Add Employee</div>
            <div class="content-card-content">
                <form id="input-form" method="post" action="../save-employee.php" enctype="multipart/form-data">
                    <input type="hidden" value="{$employee.id|default:''}" name="id">

                    <div class="label-cell"><label for="fn">First name:</label></div>
                    <div class="input-cell">
                        <input type="text" name="firstName" value="{$formData.firstName|escape }" id="fn">
                    </div>

                    <div class="label-cell"><label for="ln">Last name:</label></div>
                    <div class="input-cell">
                        <input type="text" name="lastName" value="{$formData.lastName|escape }" id="ln">
                    </div>

                    <div class="label-cell"><label for="position">Position:</label></div>
                    <div class="input-cell">
                        <select id="position" name="position">
                            <option value=" "></option>
                            <option value="Manager" {if $formData.position == 'Manager'}selected{/if}>Manager</option>
                            <option value="Developer" {if $formData.position == 'Developer'}selected{/if}>Developer</option>
                            <option value="Designer" {if $formData.position == 'Designer'}selected{/if}>Designer</option>
                            <option value="Office Pet" {if $formData.position == 'Office Pet'}selected{/if}>Office Pet</option>
                        </select>
                    </div>
                    <div class="label-cell"><label for="pic">Picture:</label></div>
                    <div class="input-cell">
                        <input id="pic" name="picture" type="file"/>
                        <label id="file-input-label" for="pic" class="current-photo-filename">
                            {if !empty($employee.profile_picture) && $employee.profile_picture != 'missing.png'}
                                Current file: {$employee.profile_picture}
                            {else}
                                Select a file
                            {/if}
                        </label>
                    </div>

                    <div class="label-cell"></div>
                    <div class="input-cell button-cell">
                        <br>
                        {if $isEditAction}
                            <input type="hidden" name="id" value="{$employeeId|escape}">
                            <input name="deleteButton" class="button danger" type="submit" value="Delete">
                        {/if}

                        <button type="submit" class="main" name="submitButton">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

        {include file='footer.tpl'}
</div>