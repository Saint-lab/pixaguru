
<form id="openai-form" action="" method="post" enctype="multipart/form-data" class="mt-24">   

  <div class="row"> 
    <div class="col-lg-4 col-md-12 col-sm-12">
      <div class="card border-0" id="template-input">
        <div class="card-body p-5 pb-0">

          <div class="row">
            <div class="template-view">
              <div class="template-icon mb-2 d-flex">
                <div>
                  <i class="fa-solid fa-image green-icon"></i>
                </div>
                <div>
                  <h6 class="mt-1 ml-3 fs-16 number-font">AI Image Generator</h6>
                </div>                  
              </div>                
              <div class="template-info">
                <p class="fs-12 text-muted mb-4">Turn any of your text into sophisticated image</p>
              </div>
            </div>
          </div>

          <div class="row">
           
            

            <div class="col-sm-12">               
              <div class="input-box"> 
                <h6 class="fs-11 mb-2 font-weight-semibold">Image Description  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>                 
                <div class="form-group">                
                  <textarea rows="5" cols="50" class="form-control" id="title" name="title" placeholder="e.g. Spaceship flying to the moon" required></textarea>
                  
                </div> 
              </div> 
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12">
              <div id="form-group">
                <h6 class="fs-11 mb-2 font-weight-semibold">Artist Name</h6>
                <select id="artist" name="artist" data-placeholder="{{ __('Select Artist Name') }}">
                  <option value='none' selected>None</option>                                                                                                                       
                  <option value="Leonardo da Vinci (Renaissance)">Leonardo da Vinci (Renaissance)</option>                                                                                                                                                                                                                                                                                                                                                                  
                  <option value="Vincent van Gogh (Impressionists and Neo-Impressionists)">Vincent van Gogh (Impressionists and Neo-Impressionists)</option>                                                                                                                                                                                                                                                                                                                                                                  
                  <option value="Pablo Picasso (Cubism)">Pablo Picasso (Cubism)</option>                                                                                                                                                                                                                                                                                                                                                                  
                  <option value="Salvador Dali (Surrealism)">Salvador Dali (Surrealism)</option>                                                                                                                                                                                                                                                                                                                                                                  
                  <option value="Banksy (Street Art)">Banksy (Street Art)</option>                                                                                                                                                                                                                                                                                                                                                                  
                  <option value="Takashi Murakami (Superflat)">Takashi Murakami (Superflat)</option>                                                                                                                                                                                                                                                                                                                                                                  
                  <option value="George Condo (Artificial Realism)">George Condo (Artificial Realism)</option>                                                                                                                                                                                                                                                                                                                                                                  
                  <option value="Tim Burton (Expressionism)">Tim Burton (Expressionism)</option>                                                                                                                                                                                                                                                                                                                                                                  
                  <option value="Normal Rockwell (exaggerated realism)">Normal Rockwell (Exaggerated Realism)</option>                                                                                                                                                                                                                                                                                                                                                                  
                  <option value="Andy Warhol (Pop Art)">Andy Warhol (Pop Art)</option>                                                                                                                                                                                                                                                                                                                                                                  
                  <option value="Claude Monet (Impressionism-Nature)">Claude Monet (Impressionism-Nature)</option>                                                                                                                                                                                                                                                                                                                                                                  
                  <option value="Robert Wyland (outdoor murals)">Robert Wyland (Outdoor Murals)</option>                                                                                                                                                                                                                                                                                                                                                                  
                  <option value="Thomas Kinkade (luminism)">Thomas Kinkade (Luminism)</option>                                                                                                                                                                                                                                                                                                                                                                  
                  <option value="Michelangelo (Fresco Art)">Michelangelo (Fresco Art)</option>                                                                                                                                                                                                                                                                                                                                                                  
                  <option value="Johannes Vermeer (impressionist)">Johannes Vermeer (Impressionist)</option>                                                                                                                                                                                                                                                                                                                                                                  
                  <option value="Gustav Klimt (fresco-secco)">Gustav Klimt (Fresco-Secco)</option>                                                                                                                                                                                                                                                                                                                                                                  
                  <option value="Sandro Botticelli (egg tempera)">Sandro Botticelli (Egg Tempera)</option>                                                                                                                                                                                                                                                                                                                                                                  
                  <option value="James Abbott (Impressionist)">James Abbott (Impressionist)</option>                                                                                                                                                                                                                                                                                                                                                                  
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
                </select>
              </div>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12">
              <div id="form-group">
                <h6 class="fs-11 mb-2 font-weight-semibold">Image Style</h6>
                <select id="style" name="style" >
                 
                    <option value='none' selected>None</option>                                                                                                                       
                    <option value='abstract'>Abstract</option>                                                                                                                        
                    <option value='realistic'>Realistic</option>                                                                                                                        
                    <option value='3d render'>3D Render</option>                                                                                                                        
                    <option value='cartoon'>Cartoon</option>                                                                                                                        
                    <option value='anime'>Anime</option>                                                                                                                        
                    <option value='digital art'>Digital Art</option>
                    <option value='modern'>Modern</option>                                                                                                                        
                    <option value='art deco'>Art Deco</option>                                                                                                                        
                    <option value='illustration'>Illustration</option>                                                                                                                        
                    <option value='origami'>Origami</option>                                                                                                                        
                    <option value='pixel art'>Pixel Art</option>                                                                                                                        
                    <option value='retro'>Retro</option>                                                                                                                        
                    <option value='photography'>Photography</option>                                                                                                                        
                    <option value='line art'>Line Art</option>                                                                                                                        
                    <option value='pop art'>Pop Art</option>                                                                                                                                                                                                                                            
                    <option value='vaporwave'>Vaporwave</option>                                                                                                                        
                    <option value='pencil drawing'>Pencil Drawing</option>                                                                                                                        
                    <option value='renaissance'>Renaissance</option>                                                                                                                        
                    <option value='minimalism'>Minimalism</option>                                                                                                                                                                                                                                              
                    <option value='sticker'>Sticker</option>                                                                                                                                                                                                                                              
                                                                                                                                                                                                                                                                                                                                                                                                                                         
                    <option value='bauhaus'>Bauhaus</option>                                                                                 
                 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
                </select>
              </div>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12">
              <div id="form-group">
                <h6 class="fs-11 mb-2 font-weight-semibold">Medium</h6>
                <select id="medium" name="medium" data-placeholder="{{ __('Select Image Medium') }}">
                  <option value='none' selected>None</option>                                                                                                                       
                  <option value='acrylic'>Acrylic</option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='canvas'>Canvas</option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='chalk'>Chalk</option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='charcoal'>Charcoal</option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='classic oil'>Classic Oil</option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='crayon'> Crayon </option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='glass'> Glass </option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='ink'> Ink </option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='paster'> Pastel </option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='pencil'> Pencil </option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='spray paint'> Spray Paint </option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='watercolor'> Watercolor </option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='wood panel'> Wood Panel </option>                                                                                                                                                                                                                                                                                                                                                                    
                </select>
              </div>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12">
              <div id="form-group">
                <h6 class="fs-11 mb-2 font-weight-semibold"> Lighting Style </h6>
                <select id="lightning" name="lightning" data-placeholder="{{ __('Select Image Lighting Style') }}">
                  <option value='none' selected> None </option>                                                                                                                       
                  <option value="warm">{{ __('Warm') }}</option>
                                    <option value="cold">Cold</option>
                                    <option value="golden hour">Golden Hour</option>
                                    <option value="blue hour">Blue Hour</option>
                                    <option value="ambient">Ambient</option>
                                    <option value="studio">Studio</option>
                                    <option value="neon">Neon</option>
                                    <option value="dramatic">Dramatic</option>
                                    <option value="cinematic">Cinematic</option>
                                    <option value="natural">Natural</option>
                                    <option value="foggy">Foggy</option>
                                    <option value="backlight">Backlight</option>
                                    <option value="hard">Hard</option>                                                                                                                                                                                                                                                                                                                                                                    
                                    <option value="soft">Soft</option>                                                                                                                                                                                                                                                                                                                                                                    
                                    <option value="irivescent">Irivescent</option>                                                                                                                                                                                                                                                                                                                                                                    
                                    <option value="fluorescent">Fluorescent</option>                                                                                                                                                                                                                                                                                                                                                                    
                                    <option value="decorative">Decorative</option>                                                                                                                                                                                                                                                                                                                                                                    
                                    <option value="accent">Accent</option>                                                                                                                                                                                                                                                                                                                                                                    
                                    <option value="task">Task</option>                                                                                                                                                                                                                                                                                                                                                                    
                                    <option value="halogen">Halogen</option>                                                                                                                                                                                                                                                                                                                                                                    
                                    <option value="light emitting diode">Light Emitting Diode (LED)</option>                                                                                                                                                                                                                                                                                                                                                                    
                </select>
              </div>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12">
              <div id="form-group">
                <h6 class="fs-11 mb-2 font-weight-semibold">Mood</h6>
                <select id="mood" name="mood" data-placeholder="{{ __('Select Image Mood') }}">
                  <option value='none' selected>None</option>                                                                                                                       
                  <option value='angry'>Angry</option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='agressive'>Agressive</option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='boring'>Boring</option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='bright'>Bright</option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='calm'>Calm</option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='cheerful'>Cheerful</option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='chilling'>Chilling</option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='colorful'>Colorful</option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='happy'>{{ __('Happy') }}</option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='dark'>Dark</option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='neutral'>Neutral</option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='sad'>Sad</option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='crying'>Crying</option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='disappointed'>Disappointed</option>                                                                                                                                                                                                                                                                                                                                                                    
                  <option value='flirt'>Flirt</option>                                                                                                                                                                                                                                                                                                                                                                    
                </select>
              </div>
            </div>

            
            
            <div class="col-lg-6 col-md-12 col-sm-12">
              <div id="form-group">
                <h6 class="fs-11 mb-2 font-weight-semibold">Image Resolution <i class="ml-1 text-dark fs-12 fa-solid fa-circle-info" data-tippy-content="{{ __('The image resolutoin of the generated images') }}"></i></h6>
                <select id="resolution" name="resolution" data-placeholder="{{ __('Set image resolution') }}">
                 
                    <option value='256x256' selected>[256x256] Small Image</option>
                    <option value='512x512'>[512x512] Medium Image</option>                                                             
                    <option value='1024x1024'>[1024x1024] Large Image</option>  
                                                                   
                </select>
              </div>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12">
              <div id="form-group">
                <h6 class="fs-11 mb-2 font-weight-semibold">Number of Variations <i class="ml-1 text-dark fs-12 fa-solid fa-circle-info" data-tippy-content="{{ __('The number of images to generate') }}"></i></h6>
                <select id="max-results" name="max_results" data-placeholder="{{ __('Set Number of Variants') }}">
                  <option value=1 selected>1</option>
                  <option value=2>2</option>                                                              
                  <option value=3>3</option>                                                              
                  <option value=4>4</option>                                                              
                  <option value=5>5</option>                                                              
                  <option value=6>6</option>                                                              
                  <option value=7>7</option>                                                              
                  <option value=8>8</option>                                                              
                  <option value=9>9</option>                                                              
                  <option value=10>10</option>                                                              
                </select>
              </div>
            </div>
          </div>            

          <div class="card-footer border-0 text-center p-0">
            <div class="w-100 pt-2 pb-2">
              <div class="text-center">
                <span id="processing" class="processing-image"><img src="{{ URL::asset('/img/svgs/upgrade.svg') }}" alt=""></span>
                <button type="submit" name="submit" class="btn btn-primary  pl-7 pr-7 fs-11 pt-2 pb-2" id="generate">Generate Image</button>
              </div>
            </div>              
          </div>  
      
        </div>
      </div>      
    </div>

    <div class="col-lg-8 col-md-12 col-sm-12">
      <div class="card border-0">
        <div class="card-body">
          <div class="d-flex">
            <div class="w-100">
              <h3 class="card-title fs-16 mt-3 mb-4"><i class="fa-solid fa-image-landscape mr-4 text-success"></i>Generated Images</h3>             
            </div>  
                  
          </div>
          <!-- SET DATATABLE -->
          <table id='resultsTable' class='table' width='100%'>
            <thead>
              <tr>
                <th width="15%">Image</th> 
                <th width="5%">Resolution</th>
                                                                                      
                <th width="5%">Actions</th>
              </tr>
            </thead>
        </table> <!-- END SET DATATABLE --> 
        </div>
      </div>
    </div>
  </div>
</form>
