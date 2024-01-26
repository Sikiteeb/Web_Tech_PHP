{include file="header.tpl"}
<body id="task-list-page">
<div id="root">
    {include file="navigation.tpl"}
    <main>
        {if isset($message) && $message neq ''}
            <div id="message-block">{$message}</div>
        {/if}
        <div class="content-card">
            <div class="content-card-header">Tasks</div>
            <div class="content-card-content">
                {foreach $tasks as $task}
                    <div class="task {$task.status}">
                        <span class="link"><a id="task-edit-link-{$task.id}" href="{$task.editLink}">Edit</a></span>

                        <div class="title" data-task-id="{$task.id}">
                            {$task.description}
                        </div>
                        <br>
                        <div id="task-state-{$task.id}" class="status {$task.status|strtolower}">
                            {$task.status|capitalize}
                        </div>
                        <div class="estimate">
                            {foreach $task.estimate as $dot}
                                <div class="dot {$dot}"></div>
                            {/foreach}
                        </div>
                    </div>
                {/foreach}
            </div>
        </div>
    </main>
    {include file="footer.tpl"}
</div>
</body>
</html>
