<?php

require_once('cache.php');

$URI="http";
$sc = false;
if (!empty($_SERVER['HTTPS'])){ $sc = true;
$URI="https";
}
$pagetitle = "Loren Lisk, linux sysadmin, nano game developer and web developer - The Official Web Site";
$name = "Loren Lisk";

//$mainParagraph = "Recently I've been narrowly focusing on containerization and Orchestration of Immutable Services, using Continous Integration and Delivery using Jenkins/kubernetes/Drone and NodeJS / Python.  I've worked within Industries all over the US. working in tons of Different Projects, and Deliverables.";

$mainParagraph = "Recently I lead development on <a href='/gallery/minecraft-creations'>LisklCraft</a>, a private <a href='".$URI."://minecraft.net/'>Minecraft</a> Server hosted on a private linux server.  I helped build the Neverwinter Nights eXtender <a href='http://www.nwnx.org/'>nwnx</a> With Papillon (Ingmar Stieger) during the years of 2003-2005.  Here is the <a href='/server.php'>Server rack</a> that runs most things I work on.  These days you can find me playing or working on <a href='/gallery/Liskl-Networks-Datacenter'>datacenter liskl</a> as well as learning about everything linux.  I work from home, and live in the amazing city of Ormond Beach, Florida.  I'm currently <a href='".$URI."://www.linkedin.com/in/liskl'>linked in</a> to many different people for many different reasons.";

echo "<!DOCTYPE HTML>\n";
echo " <head>\n";
echo "  <title>$pagetitle</title>\n";
echo "  <link rel='openid2.provider' href='https://www.google.com/accounts/o8/ud?source=profiles' />\n";
echo "  <link rel='openid2.local_id' href='http://www.google.com/profiles/loren.lisk09' />\n";
echo "  <link rel='shortcut icon'    href='/favicon.ico' />\n";
echo "  <link rel='stylesheet'       href='/css/main.css' media='screen'/>\n";
echo "  <link rel='stylesheet'       href='/css/recommend.css' media='screen'/>\n";
echo "  <link rel='stylesheet'       href='/css/print.css' media='print' />\n";
echo " </head>\n";
echo " <body>\n";
echo "  <script src='/js/ga.js' type='text/javascript'></script>\n";
echo "<script>";
echo "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');";

echo "  ga('create', 'UA-48517575-1', 'liskl.com');";
echo "  ga('send', 'pageview');";
echo "</script>";
echo "  <script type='text/javascript'>var pageTracker = _gat._getTracker('UA-5462433-1');pageTracker._initData();pageTracker._trackPageview();</script>\n";
echo "  <div id='ad_google'>\n";
echo "   <script type='text/javascript'>google_ad_client = 'ca-pub-3132001591962373'; google_ad_slot = '3600026079'; google_ad_width = 468; google_ad_height = 60;</script>\n";
echo "	 <br />\n";
echo "  </div>\n";
echo "  <center>\n";
echo "  <div class='card'>\n";
echo "   <div class='header'>\n";
echo "    <h1>\n";
echo "     <a href='/' style='text-decoration:none;border:0'>$name</a>\n";
echo "    </h1>\n";
echo "    <p>Operational Engineer, DevOps, Coder &amp; Passionate Technologist.</p>\n";
echo "   </div>\n";
echo "   <h2>Hi!</h2>\n";
echo "   <p>\n";
echo "    I'm Loren Lisk A.K.A. Liskl, and I Create.</p>";
echo "   </p>";
echo "    <img src='/img/self_image_1_200x160.jpg' style='float:right;border:solid black 1px;margin-left:10px;margin-bottom:10px;height:160px;width:120px;'/>";
echo "    $mainParagraph";
echo "   </p>";
?>


      <p>You can <a href="/email.php">send me an email</a> if you like..</p>
      <h2>Currently Doing</h2>
      <ul>
       <li><strong>Making</strong>
        <ul class="sub">
         <li class="sub">Orchestrate all the things with Kubernetes for All in house Workloads.<li>
         <li class="sub">Building IoT Power Measuring with high Sample Rates, for Machine Learning Play.<li>
         <li class="sub">Learning Node.js for fun and  profi</a>
         <li class="sub"><a href="https://pastebin.liskl.com/">Pastebin for Public Use</a> - Pasting All the Things<li>
         <li class="sub"><a href="/power/">Whole House Power Graphs</a> - automated graphs for whole house power usage.<li>
         <li class="sub"><a href="/games/">Demo HTML5 Games</a> - A place to store my demo games as i build them.<li>
         <!-- <li class="sub"><a href="/images/lisklview-02192013.jpg">liskview v0.3</a> - Work Related project to make everynes job easier.</li> --!>
         <!-- <li class="sub"><a href="http://liskl.net">Liskl Networks</a> - Datacenter Liskl</li> --!>
         <li class="sub">Liskl Networks - <a href='/gallery/Liskl-Networks-Datacenter'>Datacenter Liskl</a></li>
        </ul>
       </li>
       <li><strong>Planning</strong>
        <ul class="sub">
         <li class="sub">Refactoring puppet code for liskl.com</li>
        </ul>
       </li>
       <li><strong>Writing</strong>
        <ul class="sub">
         <li class="sub"><a href="https://confluence.liskl.com/">Personal Confluence.</a></li>
        </ul>
       </li>
      </ul>
      <h2>Completed Projects</h2>
      <ul>
       <li><strong>Scripting</strong>
        <ul class="sub">
         <li class="sub"><a href="/img/solar_bamf.jpg">83W Solar Panel</a> for Solar panel Array - 02-15-2011</li>
         <li class="sub"><a href="/img/solartracker.png">2 Axis Solar Tracker</a> for Solar panel Array - 05-15-2011</li>
         <li class="sub"><a href="http://forum.wdlxtv.com/viewtopic.php?f=49&t=1702&p=13787">UMSP Revision3 wdlxtv script.</a> - wdlxtv.org (commited on Wed Sept 29 2010)</li>
        </ul>
       </li>
      </ul>
      <div id="recent_news">
       <h2>Recent News</h2>
       <ul>
        <li><strong>April 25 2014</strong>
         <ul class='sub'>
          <li class='sub'>New Job at Peak Hosting, Linux Systems Administrator, More New and Exciting Things.</li>
         </ul>
        </li>
		<li><strong>April 12 2014</strong>
		 <ul class='sub'>
		  <li class='sub'>Medievil Times, first horse and pony show, really enjoyed the fun.</li>
		 </ul>
        </li>
		<li><strong>October 19 2014</strong>
		 <ul class='sub'>
		  <li class='sub'>Zombie Walk on the square...</li>
		 </ul>
        </li>
        <li><strong>December 2013</strong>
         <ul class='sub'>
          <li class='sub'>A few new things start next month, new diet, an exercise routine, a promise to myself to live a healther life with my sweetie.</li>
         </ul>
        </li>
        <li><strong>August 2013</strong>
         <ul class='sub'>
          <li class='sub'>New home in Marietta. 1 day migration. whew.</li>
         </ul>
        </li>
        <li><strong>Feburary 2013</strong>
         <ul class='sub'>
          <li class='sub'>Raspberry Pi, Media Center whole house solution deployed.</li>
         </ul>
        </li>
        <li><strong>June 2013</strong>
         <ul class='sub'>
          <li class='sub'>New Job at IBM, Linux Systems Administrator, New and Exciting Things.</li>
         </ul>
        </li>
        <li><strong>Feburary 2013</strong>
         <ul class='sub'>
	  <li class='sub'>New title at work, Linux Administrator III, awesome job.</li>
         </ul>
        </li>
        <li><strong>November 2012</strong>
         <ul class='sub'>
	  <li class='sub'>not to be outdone, 4 cities in 7 days [ St Augustine, St Augustine Beach, Daytona Beach, New Smyrna Beach ] <a href='/gallery/'>Pictures here</a> - Props to the <a href='http://www.daytonahotelsandresorts.com/acapulco/default-en.html'>Alcapulco resort</a></li>
         </ul>
        </li>
        <li><strong>October 2012</strong>
         <ul class='sub'>
	  <li class='sub'><strike>traffic graph for liskl.com network <a href='/wan-traffic.html'>Here</a>.</strike></li>
	  <li class='sub'><a href='http://www.fearworld.com/'>Netherworld</a> with Bill & Brian.</li>
         </ul>
        </li>
        <li><strong>August 2012</strong>
         <ul class='sub'>
	  <li class='sub'>Visited the <a href="http://www.georgiaaquarium.org/">Aquarium</a> With my Dearest Love.</li>
         </ul>
        </li>
        <li><strong>May 2012</strong>
         <ul class='sub'>
          <li class='sub'>Dungeons and Dragons Campaign Started, Charactors [Sadar, Rain, Samel, Morgran, Arrowroot, Benreos, kavaki and DM Dr, Q] </li>
         </ul>
        </li>
        <li><strong>April 2012</strong>
         <ul class='sub'>
          <li class='sub'>UPDATE: Solar Panel Install Coming Soon.</li>
         </ul>
        </li>
        <li><strong>March 2012</strong>
         <ul class='sub'>
          <li class='sub'>Earned Membership in <a href='/img/IMG_20120419_113718.jpg'>"Team Awesome"</a> at Work. [ Thanks for the ipad Peer1 ]</li><br>
          <li class='sub'>Machine gun shooting courtesy of my awesome dearest at <a href="http://www.quickshotshootingrange.com">Quickshot</a></li>
         </ul>
        </li>
        <li><strong>January 2012</strong>
         <ul class='sub'>
          <li class='sub'>New Job, <a href="http://www.peer1.com/">Peer1 Hosting</a>, Linux System Administrator II - YAY</li>
         </ul>
        </li>

        <li><strong>March 2011</strong>
         <ul class='sub'>
          <li class='sub'>finally Finished <a href='/img/solar_bamf.jpg'>83W Solar Panel</a></li><br>
          <li class='sub'>Moved out of the Marietta apartment, Moved in with my better-half [Victoria].</li><br>
          <li class='sub'>First Deep Tissue Massage from <a href='http://www.massageenvy.com/'>massage envy</a> = A++, got a membership lol.</li><br>
          <li class='sub'>Successfully Crazy Birthday Week <a href='http://www.johnniemaccrackens.com/'>Johnny McCrackens</a> We Thank you.</li><br>
          <li class='sub'>Neice Madelynn Was Born March 8th</li>
         </ul>
        </li>
        <li><strong>February 2011</strong>
         <ul class='sub'>
          <li class='sub'>Received CompTIA Network+</li>
         </ul>
        </li>
       </ul>
      </div>
      <div id="references">
       <h2>References</h2>
       <ul>
        <li><p style='margin-right:30px'><b><a href="javascript:void(0)" onclick = "document.getElementById('recommend-6').style.display='block';">Syn Calvo</a> - Peak Hosting, Coworker</b>
            <div id="recommend-6" class="white_content">
                For almost two and a half years, I had the honor of working with Loren first as a Linux System Administrator and then through the creation of a new team of Operations Engineers. Loren's knowledge and expertise were invaluable to me at Peak Hosting and he is one of the best team members I could have asked for. He is always willing to help and would seek every opportunity to trade knowledge and learn or teach something new. He is never afraid to receive honest feedback and turn advice into profit or work with his team toward a mutual solution for customer inquiries.<br>
                Loren's involvement in and understanding of Linux Administration, Problem Management and Change Management brought me to him many times for advice. He is an asset to any company looking for a rock star on their team.<br>
                <br>
                <a href="https://www.linkedin.com/in/syncalvo" target="_blank">
                    Syn Calvo
                </a>
                <br>
                <br> <a href = "javascript:void(0)" onclick = "document.getElementById('recommend-6').style.display='none';">Close</a></div></p>
        </li>


        <li><p style='margin-right:30px'><b><a href="javascript:void(0)" onclick = "document.getElementById('recommend-7').style.display='block';">Richard Staats</a> - Peak Hosting, Coworker</b>
            <div id="recommend-7" class="white_content">
                Loren is undoubtedly one of the most talented Linux Engineers I have ever worked with. It has been my pleasure working with Loren for the past year and learning all kinds of awesome new things from him. As a true Linux professional Loren is always eager to dissect complex problems and where possible automate solutions to make work faster, more accurate, and repeatable. With an insatiable passion for learning and diving deep into new tech, Loren is truly a master of his craft.<br>
                <br>
                <a href="https://www.linkedin.com/in/rstaats" target="_blank">
                    Richard Staats
                </a>
                <br>
                <br> <a href = "javascript:void(0)" onclick = "document.getElementById('recommend-7').style.display='none';">Close</a></div></p>
        </li>

        <li><p style='margin-right:30px'><b><a href="javascript:void(0)" onclick = "document.getElementById('recommend-1').style.display='block';">John Biggi</a> - Peak Hosting, CEO</b>
            <div id="recommend-1" class="white_content">
                Loren has been a consistent technical lead within Peak's Operations team. Loren has been integral in creating and delivering the content of various internal training sessions. Loren has also been at the forefront of creating processes and procedures which enabled our teams to be more efficient and effective in their delivery of services for Peak's customers. Loren's technical skills are consistently sought after by his peers as well as his cross functional teammates. I would recommend Loren for any position that requires both technical prowess as well as excellent interpersonal skills.<br>
                <br>
                <a href="https://www.linkedin.com/in/johnbiggi" target="_blank">
                    John Biggi
                </a>
                <br>
                <br> <a href = "javascript:void(0)" onclick = "document.getElementById('recommend-8').style.display='none';">Close</a></div></p>
        </li>

        <li><p style='margin-right:30px'><b><a href="javascript:void(0)" onclick = "document.getElementById('recommend-1').style.display='block';">Fereydoun Tavangary</a> - Peak Hosting, Direct Manager</b>
            <div id="recommend-8" class="white_content">
                It has been my pleasure to supervise Loren at Peak Hosting. I found him to be a hard worker, he always kept calm under pressure and I could count on him to be a natural leader. He always went above and beyond his job duties and was willing to step up and take on new challenges to help his team be successful. Loren has excellent communication skills, strong technical abilities, is organized, multi-tasks efficiently and can work well independently. <br>
                <br>
                <a href="https://www.linkedin.com/in/fereydount" target="_blank">
                    Fereydoun Tavangary
                </a>
                <br>
                <br> <a href = "javascript:void(0)" onclick = "document.getElementById('recommend-8').style.display='none';">Close</a></div></p>
        </li>

        <li><p style='margin-right:30px'><b><a href="javascript:void(0)" onclick = "document.getElementById('recommend-9').style.display='block';">Ryan King</a> - Peak Hosting, Coworker</b>
            <div id="recommend-9" class="white_content">
                Loren was one of the brightest points of my time with Peak Hosting. His interest and professional input into many areas in a high-volume, high-pressure environment were constantly helpful in making sure that everything was running smoothly. Loren's experience and guidance were invaluable in helping to formulate most of our policies and procedures in dealing with large and complex customers, and his leadership was essential in guiding our team to meet ever-changing and increasingly difficult goals. Loren proved himself time and time again to be a valuable asset to any project he was asked to handle. <br>
                <br>
                <a href="https://www.linkedin.com/in/kingrc" target="_blank">
                    Ryan King
                </a>
                <br>
                <br> <a href = "javascript:void(0)" onclick = "document.getElementById('recommend-9').style.display='none';">Close</a></div></p>
        </li>

        <li><p style='margin-right:30px'><b><a href="javascript:void(0)" onclick = "document.getElementById('recommend-10').style.display='block';">Pavel May</a> - Peak Hosting, Coworker</b>
            <div id="recommend-10" class="white_content">
                Loren is a detail-oriented, untiring, ceaselessly efficiency-minded, automation-loving Linux administrator. No task seems too big, but also no task beneath him. Loren always seeks out feedback on which to base his improvement. An utter pleasure to work with this man. <br>
                <br>
                <a href="https://www.linkedin.com/in/pavel-may-39792abb" target="_blank">
                    Pavel May
                </a>
                <br>
                <br> <a href = "javascript:void(0)" onclick = "document.getElementById('recommend-10').style.display='none';">Close</a></div></p>
        </li>

        <li><p style='margin-right:30px'><b><a href="javascript:void(0)" onclick = "document.getElementById('recommend-11').style.display='block';">Deon Rodden</a> - Peak Hosting, Coworker</b>
            <div id="recommend-11" class="white_content">
                You won't find a more dedicated geek than Loren. I mean Geek an an awesome, amazing way. He's passionate about technology, always trying new things and learning new things, always going above and beyond the call of duty. He's a dedicated, hard working Linux guru who doesn't do this just because it's a job, but because it's his passion, and it shows. If you always want to know about the latest and greatest technology, chances are Loren's testing it on his home lab. Highly recommended. <br>
                <br>
                <a href="https://www.linkedin.com/in/deonrodden" target="_blank">
                    Deon Rodden
                </a>
                <br>
                <br> <a href = "javascript:void(0)" onclick = "document.getElementById('recommend-11').style.display='none';">Close</a></div></p>
        </li>

        <li><p style='margin-right:30px'><b><a href="javascript:void(0)" onclick = "document.getElementById('recommend-12').style.display='block';">William Bakke</a> - IBM, Coworker</b>
            <div id="recommend-12" class="white_content">
                Loren Lisk is extremely dedicated, able to work great in a team or by himself on task, thrives under pressure. Always keeping his skills updated and remaining top of his game, given a new project he will learn everything he needs to know to not only complete the task but improve on it. <br>
                <br>
                <a href="https://www.linkedin.com/in/williambakke" target="_blank">
                    William Bakke
                </a>
                <br>
                <br> <a href = "javascript:void(0)" onclick = "document.getElementById('recommend-12').style.display='none';">Close</a></div></p>
        </li>

        <li><p style='margin-right:30px'><b><a href="javascript:void(0)" onclick = "document.getElementById('recommend-13').style.display='block';">Michael Gardner</a> - Peer 1 Hosting, Manager</b>
            <div id="recommend-13" class="white_content">
                Loren is one of the best Linux administrators I know. He is extremely knowledgeable in Linux, Networking and server administration. When I had the pleasure of being his leader, her stood out as the go to guy shortly after joining the company. I was impressed with how hard he worked to learn our business and master it. I constantly received great compliments and kudos our customers about him. I had customers that he impressed who only wanted to work with him. If you are looking for a hard working, knowledgeable administrator who is great with his team and customers, Loren is the person. <br>
                <br>
                <a href="https://www.linkedin.com/in/ummike" target="_blank">
                    Michael Gardner
                </a>
                <br>
                <br> <a href = "javascript:void(0)" onclick = "document.getElementById('recommend-13').style.display='none';">Close</a></div></p>
        </li>

        <li><p style='margin-right:30px'><b><a href="javascript:void(0)" onclick = "document.getElementById('recommend-14').style.display='block';">Brian Beaudoin</a> - Peer 1 Hosting, Coworker</b>
            <div id="recommend-14" class="white_content">
                Loren has always been a pleasure to work with. As an outgoing, communicative coworker, he naturally gets along with others lending his strengths to others in teams. His drive to continuously learn and improve has deepened his breadth of knowledge and experience in cloud technologies, immutable deployments, and orchestration for scalability and management. I wholeheartedly give him my recommendation. <br>
                <br>
                <a href="https://www.linkedin.com/in/bbeaudoin" target="_blank">
                    Brian Beaudoin
                </a>
                <br>
                <br> <a href = "javascript:void(0)" onclick = "document.getElementById('recommend-14').style.display='none';">Close</a></div></p>
        </li>
	<li><p style='margin-right:30px'><b><a href="javascript:void(0)" onclick = "document.getElementById('recommend-1').style.display='block';">Clarence Winfield</a> - Chattahoochee Technical College, Coworker</b>
	    <div id="recommend-1" class="white_content">Loren is very technical and knowlegeable of his position and many other aspects and areas of the Technical Support division of Chattahoochee Technical College. Not only does he performs his primary duties efficiently and promptly, his performance is the same or better when assigned to or volunteers to help with other projects. He is always trying/willing to learn more and is constantly getting training for and works hard at earning various IT certifications. Working with Loren has also increased my knowledge in some area's of IT.<br><br><a href="http://www.linkedin.com/pub/clarence-winfield/14/b5b/375" target="_blank">Clarence Winfield</a><br><br> <a href = "javascript:void(0)" onclick = "document.getElementById('recommend-1').style.display='none';">Close</a></div></p>
 	</li>
	<li><p style='margin-right:30px'><b><a href="javascript:void(0)" onclick = "document.getElementById('recommend-2').style.display='block';">Kay Kamara</a> - Chattahoochee Technical College, Teacher</b>
	    <div id="recommend-2" class="white_content">Loren was an outstanding student who has a keen understanding of all technical aspects for the field of study. He has a genuine IT knowledge more than any other students that I have taught. It is Loren's firm understanding of the technology field that has made him one for the strongest candidate in his field. I highly recommend Loren for his endeavors. Loren is a highly motivated, dedicated, and a knowledgeable student who will succeed and any task. I have no doubt that he will be highly regarded as a valuable team member. I am confident that he will take a full advantage of the opportunities that you offer.<br><br><a href="http://www.linkedin.com/pub/kamara-kay-mism/a/345/7b7" target="_blank">Kay Kamara</a><br><br><a href = "javascript:void(0)" onclick = "document.getElementById('recommend-2').style.display='none';">Close</a></div></p>
 	</li>
	<li><p style='margin-right:30px'><b><a href="javascript:void(0)" onclick = "document.getElementById('recommend-3').style.display='block';">Victoria Gardner</a> - Chattahoochee Technical College, Manager</b>
	    <div id="recommend-3" class="white_content">As a Federal Work Study, Loren put in more hours than required under the program, often keeping the pace of many of the full time staff. His diversity in the technology field, gained as much under personal experience as education, made him a great asset during his time in our support department. Problem solving is among his many strengths. Not afraid of a challenge, Loren took his personal time to "tweak" existing applications, making them more efficient, faster, saving time and resources. He is supportive of other people's ideas and will offer to help to bring about the best results.<br><br><a href="http://www.linkedin.com/pub/victoria-gardner/19/b35/140" target="_blank">Victoria Gardner</a><br><br> <a href = "javascript:void(0)" onclick = "document.getElementById('recommend-3').style.display='none';">Close</a></div></p>
 	</li>
	<li><p style='margin-right:30px'><b><a href="javascript:void(0)" onclick = "document.getElementById('recommend-4').style.display='block';">Enrique Velazquez</a> - Peer1 Hosting, Executive Staff</b>
	    <div id="recommend-4" class="white_content">To Whom It May Concern, <br><br>I have had the distinct pleasure of working with Loren Lisk during our shared time at Peer 1 Hosting.  In that time he had consistently gone above and beyond the call of duty in a number of ways.  The most impactful of which would be developing a new ticketing dashboard that not only impacted the Atlanta office, but because the tool used worldwide across our entire office. <br><br>His dedication and excellent customer service skills are top notch, and he would be an asset to any company who'd want to hire him.<br><br><a href="http://www.linkedin.com/pub/enrique-velazquez/b/567/a49" target="_blank">Enrique Velazquez</a><br><br> <a href = "javascript:void(0)" onclick = "document.getElementById('recommend-4').style.display='none';">Close</a></div></p>
 	</li>
	<li><p style='margin-right:30px'><b><a href="javascript:void(0)" onclick = "document.getElementById('recommend-5').style.display='block';">Jeff Bragdon</a> - Peer1 Hosting, Direct Supervisor</b>
	    <div id="recommend-5" class="white_content">To Whom It May Concern, <br><br>Over the course of my employment with Peer1, I had the great pleasure of filling the role of a supervisor responsible for Loren Lisk. He proved himself over and over again an excellent Linux engineer with deep understanding of the root operating systems and applications that make business class hosting successful.<br><br> I came to rely on him for his ability to quickly resolve issues, his quality customer service, and his overall job performance. <br><br>Often, he was talked about in management meetings as one of our anchors for which we built shifts around. <br><br>Recently I left Peer1 for another opportunity which is only a Windows based environment, or I would be after Loren myself. <br><br>You could not ask for a more hard working, intelligent, experienced Linux engineer.<br><br><a href="http://www.linkedin.com/pub/jeff-bragdon/3/636/863" target="_blank">Jeff Bragdon</a><br><br> <a href = "javascript:void(0)" onclick = "document.getElementById('recommend-5').style.display='none';">Close</a></div></p>
 	</li>
       </ul>
      </div>
      <div id="FAFOC">
      <h2>Friends and Fellows of Real Value</h2>
      <ul>
       <li><strong>Technology</strong>
        <ul class="sub">
         <li class="sub">Victoria Gardner - <a href="http://shesgeeky.blogspot.com/view/snapshot">Victoria's Blog</a></li>
         <li class="sub">Sean Kennedy - <a href="http://darkatlas.com/">DarkAtlas</a></li>
        </ul>
       </li>
      </ul>
      <br />
      <p style="margin-left:30px">Thanks for your interest.<br />
       Resume: <a onClick="javascript:pageTracker._trackEvent('PDF','Download','Resume-Dec-29-2015.pdf'); void(0);" href='/pdf/Resume-Dec-29-2015.pdf'>PDF</a> <b><font size="1">[Updated January 29, 2015]</font></b><br />

<!--       Transcript: <a onClick="javascript:pageTracker._trackEvent('Comptia','View','Transcript'); void(0);" href='https://www.certmetrics.com/comptia/public/transcript.aspx?transcript=BESK70G1K2R1SGWH'>CompTIA</a> -->
      </p>
      <div class="footerquote">
       <p>"If I had more time, I would have made this shorter."</p>
<center>
<?php
	#$a = session_id();
	#if(empty($a)) session_start();
	#echo session_id()."<br>";

	#if(!isset($_SESSION['visit']))
	#{
	#	echo "This is the first time you're visiting this server\n";
	#	$_SESSION['visit'] = 0;
	#}
	#else
	#	echo "Your number of visits: ".$_SESSION['visit'] . "\n";

	#$_SESSION['visit']++;

?>
<!--
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="hosted_button_id" value="Q4W35QXSUBNMC">
	<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
	<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
	</form>-->
</center>
    <a href="/">Top Of Page</a>
      </div>
      </div>
     </center>
     <br>
     <div id="fade" class="black_overlay"></div>
    </body>
   </html>
