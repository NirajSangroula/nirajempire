			function opena(){
				var x = document.getElementById('navcontents');
				var y = document.getElementById('menutoggler1');
				var z = document.getElementById('menutoggler');
				var t = document.getElementById('contents');
				x.style.display="block";
				y.style.display="block";
				z.style.display="none";
				t.style.float="left";
				t.style.width="62.5rem";
			}

			function closea(){
				var x = document.getElementById('navcontents');
				var y = document.getElementById('menutoggler1');
				var z = document.getElementById('menutoggler');
				var t = document.getElementById('contents');
				x.style.display="none";
				y.style.display="none";
				z.style.display="block";
				t.style.float="none";
				t.style.width="81.8125rem";
			}
			function showcontents(b){
				var x = document.getElementById('manipulate'+b);
				var y = document.getElementById('showcomments'+b);
				var z = document.getElementById('hidecomments'+b);
				x.style.display="block";
				y.style.display="none";
				z.style.display="block";
			}
			function hidecontents(b){
				var x = document.getElementById('manipulate'+b);
				var y = document.getElementById('showcomments'+b);
				var z = document.getElementById('hidecomments'+b);
				x.style.display="none";
				y.style.display="block";
				z.style.display="none";
			}
			