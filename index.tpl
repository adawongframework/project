ȷ��./tmpĿ¼��д��Ȩ��:chmod -R 0777 ./tmp</br/>
<!--�����ļ�-->
{template head.tpl/}</br>
<!--��̬����-->
�������:{Uri::host()/}<br/>
<!--ѡ��ṹ-->
{if $total ==10}
	total����10<br/>
{elseif $total >= 10}
	total���ڵ���10<br/>
{else}
	totalС��10<br/>
{/if}
<!--ѭ���ṹ-->
{loop var=$array key=$index}
{$array[$index]/}<br/>
{/loop}