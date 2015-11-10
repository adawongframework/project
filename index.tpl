确保/tmp有写入权限
<!--包含文件-->
{template head.tpl/}</br>
<!--静态方法-->
你的主机:{Uri::host()/}<br/>
<!--选择结构-->
{if $total ==10}
	total等于10<br/>
{elseif $total >= 10}
	total大于等于10<br/>
{else}
	total小于10<br/>
{/if}
<!--循环结构-->
{loop var=$array key=$index}
{$array[$index]/}<br/>
{/loop}