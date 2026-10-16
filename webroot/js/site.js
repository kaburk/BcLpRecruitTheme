/**
 * BcLpRecruitTheme : baserCMS5 採用 LP テーマ
 *
 * 共通 JS（jQuery 不要）
 * - SP メニューの開閉
 * - セクション見出しの英字ラベル（ブロックの ID から生成）
 * - 数字で見る会社の数字を大きくする
 * - よくある質問の開閉
 * - メールフォームの送信モード設定（BcMail の form-submit.js の代わり）
 */
(function () {
	'use strict';

	// SP メニュー
	var burger = document.querySelector('[data-rc-drawer-toggle]');
	var drawer = document.getElementById('rc-drawer');
	if (burger && drawer) {
		var setMenu = function (open) {
			burger.setAttribute('aria-expanded', open ? 'true' : 'false');
			burger.setAttribute('aria-label', open ? 'メニューを閉じる' : 'メニューを開く');
			drawer.hidden = !open;
		};
		burger.addEventListener('click', function () { setMenu(drawer.hidden); });
		drawer.querySelectorAll('a').forEach(function (a) {
			a.addEventListener('click', function () { setMenu(false); });
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && !drawer.hidden) { setMenu(false); burger.focus(); }
		});
	}

	// セクション見出しの英字ラベル：ID「bge-about-us」→「ABOUT US」（見出しの枠に付け、番号の右上に出す）
	document.querySelectorAll('.bge-contents > .rc-blk--section[id^="bge-"]').forEach(function (el) {
		var label = el.id.replace(/^bge-/, '').replace(/[-_]+/g, ' ').toUpperCase();
		var box = el.querySelector('.bgt-title-h2-container');
		if (label && box) { box.setAttribute('data-rc-label', label); }
	});

	// 数字で見る会社：内容欄の1行目「48名」「週3日まで」を、単位・数字・単位に分けて数字だけを大きくする
	document.querySelectorAll('.rc-blk--numbers td').forEach(function (td) {
		var first = td.firstChild;
		if (!first || first.nodeType !== 3) { return; }
		var m = first.nodeValue.trim().match(/^(\D*?)(\d[\d.,]*)(\D*)$/);
		if (!m) { return; }
		var line = document.createElement('span');
		line.className = 'rc-num';
		[[m[1], 'small'], [m[2], 'b'], [m[3], 'small']].forEach(function (part) {
			if (!part[0]) { return; }
			var el = document.createElement(part[1]);
			el.textContent = part[0];
			line.appendChild(el);
		});
		td.replaceChild(line, first);
		if (line.nextSibling && line.nextSibling.nodeName === 'BR') { td.removeChild(line.nextSibling); }
	});

	// よくある質問：h3 の中にボタンを入れ、直後の回答を開閉する（最初の1問だけ開いておく）
	document.querySelectorAll('.rc-blk--faq .bge-ckeditor').forEach(function (box, boxIndex) {
		box.querySelectorAll('h3').forEach(function (h3, i) {
			var answers = [];
			var next = h3.nextElementSibling;
			while (next && next.tagName !== 'H3') { answers.push(next); next = next.nextElementSibling; }
			if (!answers.length) { return; }
			var id = 'rc-faq-' + boxIndex + '-' + i;
			var btn = document.createElement('button');
			btn.type = 'button';
			btn.className = 'rc-faq__toggle';
			btn.setAttribute('aria-controls', id);
			while (h3.firstChild) { btn.appendChild(h3.firstChild); }
			h3.appendChild(btn);
			answers[0].id = id;
			var set = function (open) {
				btn.setAttribute('aria-expanded', open ? 'true' : 'false');
				h3.classList.toggle('is-collapsed', !open);
				answers.forEach(function (a) { a.hidden = !open; });
			};
			set(i === 0);
			btn.addEventListener('click', function () { set(btn.getAttribute('aria-expanded') !== 'true'); });
		});
	});

	// メールフォーム：押したボタンに応じて mode を設定（Confirm / Back / Submit）
	var mode = document.getElementById('MailMessageMode');
	if (mode) {
		document.querySelectorAll('.form-submit').forEach(function (btn) {
			btn.addEventListener('click', function () {
				btn.style.pointerEvents = 'none';
				mode.value = (btn.id || '').replace('BtnMessage', '');
			});
		});
	}
})();
