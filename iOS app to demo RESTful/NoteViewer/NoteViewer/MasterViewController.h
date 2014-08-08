//
//  MasterViewController.h
//  NoteViewer
//
//  Created by Evan Spielberg on 8/4/14.
//  Copyright (c) 2014 Evan Spielberg. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "Reachability.h"
@interface MasterViewController : UITableViewController


@property (nonatomic,retain) NSString * userNameString;
@property (nonatomic,retain) NSString * userIDString;
@property (nonatomic,retain) NSString * userPasswordString;
//@property (nonatomic,retain) NSDictionary *allNotesDictionary;
@property (nonatomic,retain) NSArray *allNotesArray;
@property(nonatomic, strong) NSArray *tableArray;
@property (nonatomic, strong) IBOutlet UITableView *tableView;
@end
