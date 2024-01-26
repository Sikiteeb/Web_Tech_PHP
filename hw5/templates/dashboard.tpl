{include file="header.tpl"}
<body id="dashboard-page">
<div id="root">
    {include file="navigation.tpl"}
    <main>
        <div>
            <div id="dash-layout">
                <div class="content-card">
                    <div class="content-card-header">Employees</div>
                    <div class="content-card-content">
                        {foreach from=$employees item=employee}
                            <div class="employee-item">
                                <img src="../static/img/{$employee.profile_picture|escape}" alt="Profile picture of {$employee.name|escape}"/>
                                <span class="name">{$employee.name|escape}</span>
                                <span id="employee-task-count-{$employee.id}" class="count">{$employee.task_count}</span>
                                <br><span class="position">{$employee.position|escape}</span>
                            </div>
                        {/foreach}
                    </div>
                </div>

                <div class="content-card">
                    <div class="content-card-header">Tasks</div>
                    <div class="content-card-content">
                        {foreach from=$tasks item=task}
                            <div class="task {$task.status|strtolower}">
                                <span class="link"><a id="task-edit-link-{$task.id}" href="?cmd=task-form&id={$task.id}">Edit</a></span>
                                <div class="title">
                                    <div data-task-id="{$task.id}">{$task.description|escape}</div>
                                </div>
                                <br>
                                <div id="task-state-{$task.id}" class="status {$task.status|strtolower}">{$task.status|capitalize}</div>
                                {for $i=0 to 4}
                                    <div class="dot {if $i < $task.estimate}filled{/if}"></div>
                                {/for}
                            </div>

                        {/foreach}
                    </div>
                </div>
            </div>
        </div>
    </main>
    {include file="footer.tpl"}
</div>
</body>