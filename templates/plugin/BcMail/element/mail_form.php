<?php
/**
 * BcLpRecruitTheme : baserCMS 5 採用 LP テーマ
 *
 * メールフォーム
 *
 * bc-front の mail_form.php をもとにしている。違いは次の2点
 * - jQuery 前提の BcMail.form-submit を読み込まない（同じ処理をテーマの site.js で行う）
 * - ボタンのクラスと並び
 *
 * $this->Mailform->create() にて、valueSources オプションで、context を明示的に指定する。
 * ファイルフィールドの確認画面にて、$_POST からの配列のデータを取得し Warning となってしまうため。
 *
 * @var \BcMail\View\MailFrontAppView $this
 * @var bool $freezed 確認画面かどうか
 * @var \BcMail\Model\Entity\MailContent $mailContent メールコンテンツデータ
 * @var \BcMail\Model\Entity\MailMessage $mailMessage
 */
// ブラウザのヒストリーバック（戻るボタン）対応
$this->Mail->token();
?>

<?php if (!$freezed): ?>
	<?php echo $this->BcBaser->createMailForm($mailMessage, ['url' => $this->BcBaser->getContentsUrl(null, false, null, false) . 'confirm', 'type' => 'file', 'valueSources' => ['context'], 'novalidate' => true]) ?>
<?php else: ?>
	<?php echo $this->BcBaser->createMailForm($mailMessage, ['url' => $this->BcBaser->getContentsUrl(null, false, null, false) . 'submit', 'valueSources' => ['context']]) ?>
<?php endif; ?>

<?php $this->BcBaser->unlockMailFormField('mode') ?>
<?php echo $this->BcBaser->mailFormHidden('mode', ['id' => 'MailMessageMode']) ?>

<table class="bs-mail-form-body">
	<?php $this->BcBaser->element('mail_input', ['blockStart' => 1]) ?>
</table>

<?php if ($mailContent->auth_captcha): ?>
	<?php $this->BcBaser->mailFormAuthCaptcha('auth_captcha', ['helper' => $this->BcBaser]) ?>
<?php endif ?>

<div class="bs-mail-form-submit">
	<?php if ($freezed): ?>
		<?php echo $this->BcBaser->mailFormSubmit(__d('baser_core', '書き直す'), ['div' => false, 'class' => 'bs-button form-submit', 'id' => 'BtnMessageBack']) ?>
		<?php echo $this->BcBaser->mailFormSubmit(__d('baser_core', '送信する'), ['div' => false, 'class' => 'bs-button form-submit', 'id' => 'BtnMessageSubmit']) ?>
	<?php else: ?>
		<?php echo $this->BcBaser->mailFormSubmit(__d('baser_core', '入力内容を確認する'), ['div' => false, 'class' => 'bs-button form-submit', 'id' => 'BtnMessageConfirm']) ?>
	<?php endif; ?>
</div>

<?php echo $this->BcBaser->endMailForm() ?>
