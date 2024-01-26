{include file="header.tpl"}
<body id="employee-list-page">
<div id="root">
    {include file="navigation.tpl"}
<main>
    {if isset($message) && $message neq ''}
        <div id="message-block">{$message}</div>
    {/if}

    <div class="content-card">
        <div class="content-card-header">Employees</div>
        <div class="content-card-content">
        <div class="employee-list">
            {foreach from=$employees item=employee}
                <div class="employee-item">
                    <img class="employee-photo" src="{$employee.profile_picture|escape}" alt="Profile picture of {$employee.firstName|escape} {$employee.lastName|escape}" data-employee-id="{$employee.id|escape}"/>
                    <span class="name" data-employee-id="{$employee.id|escape}">{$employee.firstName|escape} {$employee.lastName|escape}</span>
                    <span class="link"><a id="employee-edit-link-{$employee.id|escape}" href="{$employee.editLink|escape}">Edit</a></span>
                    <br><span class="position">{$employee.position}</span>
                </div>
            {/foreach}

        </div>
        </div>
   </div>
</main>
    {include file="footer.tpl"}
</div>
</body>


