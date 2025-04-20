          <div class="col-xs-4 loop_sec" id="<?php echo $font2->noticefont_id; ?>">
        <div class="hvr-grow2 limitboard" id="<?php echo $font2->noticefont_id;; ?>">
        
        <div class="holidays_list" id="{{$font2->noticefont_id }}"  >
        <div  style="cursor:move; width: 100%;" class="holidays_h">{{$font2->message_subject  }}</div>
        <div  style="cursor:pointer">
        <p class="holidays_content swapboard1" id="body{{ $font2->noticefont_id }}" onclick="openbodyModal('{{ $font2->noticefont_id }}')" >
            {{ (strlen($font2->message) > 625)? substr(strip_tags($font2->message), 0, 625)."...": strip_tags($font2->message) }}
        </p>
        </div>
        <div class="clear"></div>
        
        <div class="bottom_content">
        
                <p class="posted_t">Posted by {{ $userfullname->fname }} {{ $userfullname->lname}} {{$font2->created }}</p>
                
                <input type="hidden" name="sort_id" id="sort_id" value="{{ $font2->sort_id }}" />
                
                 <input type="hidden" name="noticefont_id" id="noticefont_id" value="{{ $font2->noticefont_id }}" />
                
                <div class="edit_controlar">
        <a  href="#" data-template_id="{{ $font2->noticefont_id }}" onclick="openModal('{{ $font2->noticefont_id }}')"><img src="img/edit_icon.png"  /></a>
        <a href="/delete-template/{{ $font2->noticefont_id }}" onClick="return delfun()"><img src="img/cross.png" /></a>
                </div>
                        
                <div class="clearfix"></div>
          
        </div>
        </div>
         
        </div></div>
    
    
    


