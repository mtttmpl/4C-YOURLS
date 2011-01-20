<?php
require_once( dirname(dirname(__FILE__)).'/includes/load-yourls.php' );

yourls_html_head( 'tools', 'Cool  Tools' );
yourls_html_logo();
?>

	<div class="sub_wrap">
	
	<h2>Bookmarklets</h2>
	
		<p>YOURLS comes with <span>four</span> handy <span>bookmarklets</span> for easier link shortening.</p>

		<h3>Standard or Instant, Simple or Custom</h3>
		
		<ul>
			<li>The <span>Standard Bookmarklets</span> will take you to a page where you can easily edit or delete your brand new short URL.</li>
			
			<li>The <span>Instant Bookmarklets</span> will pop the short URL without leaving the page you are viewing.</li>
			
			<li>The <span>Simple Bookmarklets</span> will generate a short URL with a random or sequential keyword</li>
			
			<li>The <span>Custom Keyword Bookmarklets</span> will prompt you for a custom keyword first</li>
		</ul>
		
		<p>With the Standard Bookmarklets you will also get a <span>Quick Share</span> tool box to make posting to Twitter, Facebook or Friendfeed a snap. If you want to share a description along with the link you're shortening, simply <span>select text</span> on the page you're viewing before clicking on your bookmarklet link</p>
		
		<h3>The Bookmarklets</h3>
		
		<p>Click and drag links to your toolbar (or right-click and bookmark it)</p>
		
		<table class="tblSorter" cellpadding="0" cellspacing="1">
			<thead>
			<tr>
				<td>&nbsp;</td>
				<th>Standard (new page)</th>
				<th>Instant (popup)</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<th class="header">Simple</th>
				<td><a href="javascript:(function()%7Bvar%20d=document,w=window,enc=encodeURIComponent,e=w.getSelection,k=d.getSelection,x=d.selection,s=(e?e():(k)?k():(x?x.createRange().text:0)),s2=((s.toString()=='')?s:('%22'+enc(s)+'%22')),f='<?php echo 'http://4c.to/index.php'); ?>',l=d.location,p='?u='+enc(l.href)+'&t='+enc(d.title)+'&s='+s2,u=f+p;try%7Bthrow('ozhismygod');%7Dcatch(z)%7Ba=function()%7Bif(!w.open(u))l.href=u;%7D;if(/Firefox/.test(navigator.userAgent))setTimeout(a,0);else%20a();%7Dvoid(0);%7D)()" class="bookmarklet" onclick="alert('Drag to your toolbar!');return false;">Shorten</a></td>
				<td><a href="javascript:(function()%7Bvar%20d=document,s=d.createElement('script');window.yourls_callback=function(r)%7Bif(r.short_url)%7Bprompt(r.message,r.short_url);%7Delse%7Balert('An%20error%20occured:%20'+r.message);%7D%7D;s.src='<?php echo 'http://4c.to/index.php'); ?>?u='+encodeURIComponent(d.location.href)+'&jsonp=yourls';void(d.body.appendChild(s));%7D)();" class="bookmarklet" onclick="alert('Drag to your toolbar!');return false;">Instant Shorten</a></td>
			</tr>
			<tr>
				<th class="header">Custom Keyword</th>
				<td><a href="javascript:(function()%7Bvar%20d=document,w=window,enc=encodeURIComponent,e=w.getSelection,k=d.getSelection,x=d.selection,s=(e?e():(k)?k():(x?x.createRange().text:0)),s2=((s.toString()=='')?s:('%22'+enc(s)+'%22')),f='<?php echo 'http://4c.to/index.php'); ?>',l=d.location,k=prompt(%22Custom%20URL%22),k2=(k?'&k='+k:%22%22),p='?u='+enc(l.href)+'&t='+enc(d.title)+''+s2+k2,u=f+p;if(k!=null)%7Btry%7Bthrow('ozhismygod');%7Dcatch(z)%7Ba=function()%7Bif(!w.open(u))l.href=u;%7D;if(/Firefox/.test(navigator.userAgent))setTimeout(a,0);else%20a();%7Dvoid(0)%7D%7D)()" class="bookmarklet" onclick="alert('Drag to your toolbar!');return false;">Custom shorten</a></td>
				<td><a href="javascript:(function()%7Bvar%20d=document,k=prompt('Custom%20URL'),s=d.createElement('script');if(k!=null){window.yourls_callback=function(r)%7Bif(r.short_url)%7Bprompt(r.message,r.short_url);%7Delse%7Balert('An%20error%20occured:%20'+r.message);%7D%7D;s.src='<?php echo 'http://4c.to/index.phpp'); ?>?u='+encodeURIComponent(d.location.href)+'&k='+k+'&jsonp=yourls';void(d.body.appendChild(s));%7D%7D)();" class="bookmarklet" onclick="alert('Drag to your toolbar!');return false;">Instant Custom Shorten</a></td>
			</tr>
			</tbody>
		</table>
		
	<h2>Prefix-n-Shorten</h2>
		
		<p>When viewing a page, you can also prefix its full URL: just head to your browser's address bar, add "<span><?php echo preg_replace('@https?://@', '', YOURLS_SITE); ?>/</span>" to the beginning of the current URL (right before its 'http://' part) and hit enter.</p>
		
		<p>Note: this will probably not work if your web server is running on Windows <?php if( yourls_is_windows() ) echo '(which seems to be the case here)'; ?>.</p>
	</div>

<?php yourls_html_footer(); ?>