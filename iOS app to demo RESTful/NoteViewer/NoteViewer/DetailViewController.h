//
//  DetailViewController.h
//  NoteViewer
//
//  Created by Evan Spielberg on 8/4/14.
//  Copyright (c) 2014 Evan Spielberg. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface DetailViewController : UIViewController

@property (strong, nonatomic) id detailItem;
@property (strong, nonatomic) NSDictionary *noteDictionary;
@property (weak, nonatomic) IBOutlet UITextView *noteDescriptionView;
@property (nonatomic,retain) NSString * userNameString;
@property (nonatomic,retain) NSString * userIDString;
@property (nonatomic,retain) NSString * userPasswordString;




@property (weak, nonatomic) IBOutlet UILabel *detailDescriptionLabel;
- (IBAction)saveEditsButtonClicked:(UIButton *)sender;

- (IBAction)deleteNoteButtonClicked:(id)sender;

-(void)setDictionary:(NSDictionary *) dict;
@end
