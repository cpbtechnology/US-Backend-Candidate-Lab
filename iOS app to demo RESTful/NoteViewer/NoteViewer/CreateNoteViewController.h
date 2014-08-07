//
//  CreateNoteViewController.h
//  NoteViewer
//
//  Created by Evan Spielberg on 8/7/14.
//  Copyright (c) 2014 Evan Spielberg. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface CreateNoteViewController : UIViewController

@property (weak, nonatomic) IBOutlet UITextView *noteTitleView;
@property (weak, nonatomic) IBOutlet UITextView *noteDescriptionView;
@property (nonatomic,retain) NSString * userNameString;
@property (nonatomic,retain) NSString * userIDString;
@property (nonatomic,retain) NSString * userPasswordString;

@end
