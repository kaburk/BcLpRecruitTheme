<?php
/**
 * BcLpRecruitTheme : baserCMS 5 採用 LP テーマ
 *
 * メールフォーム：入力
 *
 * - 見出し：メールフォームのタイトル
 * - リード文：メールフォーム設定の「説明文」
 * - 項目：メールフィールド（管理画面で追加・並べ替えできる）
 *
 * @var \BcMail\View\MailFrontAppView $this
 */
?>
<section class="rc-fhero">
	<div class="rc-wrap rc-wrap--narrow">
		<p class="rc-eyebrow">Entry form</p>
		<h1 class="rc-fhero__title"><?php $this->BcBaser->contentsTitle() ?></h1>
		<div class="rc-fhero__lead"><?php $this->Mail->description() ?></div>
		<?php $this->BcBaser->element('lp_steps', ['current' => 1]) ?>
	</div>
</section>
<section class="rc-fsec">
	<div class="rc-wrap rc-wrap--narrow">
		<div class="rc-fcard">
			<?php $this->BcBaser->flash() ?>
			<div class="rc-form">
				<?php $this->BcBaser->element('mail_form') ?>
			</div>
		</div>
	</div>
</section>
