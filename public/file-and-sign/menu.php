						<ul class="nav nav-tabs nav-tabsbg">
							<li <?=($cur_page=="index.php" || $cur_page=="upload-document.php" || $cur_page=="sign-a-document.php")?'class="active"':'class=""'?>>
								<a id="tab1documents" href="<?=$SITE_URL?>">DOCUMENTS</a>
							</li>
							
							<?php /*?><li <?=($cur_page=="send-for-signature.php")?'class="active"':'class=""'?>>
								<a id="tab2documents" href="send-for-signature.php">SEND FOR SIGNATURE</a>
							</li><?php */?>
							
							<li <?=($cur_page=="signed-signature.php")?'class="active"':'class=""'?>>
								<a id="tab3documents" href="signed-signature.php">SIGNED DOCS</a>
							</li>
							
							<li <?=($cur_page=="share-document.php")?'class="active"':'class=""'?>>
								<a id="tab4sharefile" href="share-document.php">CLIENT PORTAL</a>
							</li>
							
							<li class="chk_right">
								<div class="icheckbox_minimal" aria-checked="false" aria-disabled="false" style="position: relative;">
									<input type="checkbox" name="notification" id="notification" style="position: absolute; opacity: 0;">
									<ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins>
								</div>
							<!--  <span class="red_point">4</span> -->
							</li>
						</ul>